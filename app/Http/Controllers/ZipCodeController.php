<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ZipCode;
use GuzzleHttp;
use Maatwebsite\Excel\Facades;
use DB;
class ZipCodeController extends Controller
{

    /**
     * Call the function to process the .CSV file and show the index view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->proccessCSV();
        return view('index');
    }

    /**
     * Truncate database for store new data from .CVS file
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function truncate(){
        ZipCode::query()->truncate();
        return redirect('index');
    }

    /**
     * Validate form of the index view
     * Split the agents and call the respective functions for them
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'zipCodeAngent1'=>'exists:zipcodes,code',
            'zipCodeAngent2'=>'exists:zipcodes,code',

        ]);

        $agent1=ZipCode::where('code', '=', $request->zipCodeAngent1)->first();

        $agent2=ZipCode::where('code', '=', $request->zipCodeAngent2)->first();

        $contacts=ZipCode::where('code', '!=', $request->zipCodeAngent2)->where('code', '!=', $request->zipCodeAngent1)->get();

        foreach ($contacts as $key => $value) {
            $distanceWithAgent1=$this->vincentyGreatCircleDistance($value["lat"],$value["lng"],$agent1["lat"],$agent1["lng"]);
            $distanceWithAgent2=$this->vincentyGreatCircleDistance($value["lat"],$value["lng"],$agent2["lat"],$agent2["lng"]);

            if($distanceWithAgent1<$distanceWithAgent2){
                DB::table('zipcodes')
                    ->where('code', $value["code"])
                    ->update(['agentId' => 1]);
            }else{
                DB::table('zipcodes')
                    ->where('code', $value["code"])
                    ->update(['agentId' => 2]);
            }

        }

        if(empty($request->umbral)){
            $request->umbral=0;
        }
        if(ZipCode::where(['agentId' => 1])->get()->count()==0){
            $this->getLessDistanceForUmbral($contacts,$request->umbral,$agent1,1);
        }
        if(ZipCode::where(['agentId' => 2])->get()->count()==0){
            $this->getLessDistanceForUmbral($contacts,$request->umbral,$agent2,2);
        }

        $results=ZipCode::all();
        return view('results',[
            'results'=>$results,
            'agent1'=>$agent1["code"],
            'agent2'=>$agent2["code"],
        ]);
    }

    /**
     * Process the .CSV file and store it in the database
     */
    public function proccessCSV(){
        $data=null;
        Facades\Excel::load('dataContacts.csv', function($reader) {

            // Getting all results
            $data = $reader->get();

            foreach ($data as $key => $value) {

                    //Do stuff when user exists.
                $user = ZipCode::where('code', $value["zipcode"])->get();


                if ($user->isEmpty()){

                    $zipCode= new ZipCode();

                    $zipCode->name=$value["name"];

                    $zipCode->code=$value["zipcode"];

                    $valuesLatLng=$this->zipCodeToLngLat($zipCode->code);

                    $zipCode->lat=$valuesLatLng["lat"];
                    $zipCode->lng=$valuesLatLng["lng"];

                    $zipCode->save();
                }
            }
        });
    }


    /**
     * Calculates the great-circle distance between two points, with
     * the Vincenty formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    protected static function vincentyGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
            pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
    }

    /**
     * This function find the less distance from the agent to the contacts
     * when the agent doesn't have any contacts and the user put a umbral for the
     * minimum value
     * @param $contacts
     * @param $umbral
     * @param $agent
     * @param $numberAgent
     */
    protected function getLessDistanceForUmbral($contacts,$umbral,$agent,$numberAgent){
        $arrayPriority=array();
        foreach ($contacts as $key => $value) {
            $distanceWithAgent1=$this->vincentyGreatCircleDistance($agent["lat"],$agent["lng"],$value["lat"],$value["lng"]);

            if(count($arrayPriority)==$umbral){
                $arrayPriority[$value["code"]]=$distanceWithAgent1;
                asort($arrayPriority);
                array_pop($arrayPriority);
            }else{
                $arrayPriority[$value["code"]]=$distanceWithAgent1;
                asort($arrayPriority);
            }
        }
        foreach ($arrayPriority as $key => $value) {
            DB::table('zipcodes')
                ->where('code', $key)
                ->update(['agentId' => $numberAgent]);
        }

    }
}
