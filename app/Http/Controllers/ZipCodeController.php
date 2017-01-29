<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\ZipCode;
use App\Contact;
use App\Agent;
use GuzzleHttp;
use Maatwebsite\Excel\Facades;
use DB;
class ZipCodeController extends Controller
{
    private $earthRadius;

    public function __construct()
    {
        $this->earthRadius = 6371000;
        $this->highestValue=INF;
    }
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
        try{
            DB::statement("SET foreign_key_checks=0");
            Contact::query()->truncate();
            DB::statement("SET foreign_key_checks=1");
        }
        catch(\Exception $e){
            $e->getMessage();
        }

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
//        dd($request);
        $this->validate($request, [
            'inputs.*'=>'exists:contacts,code',
        ]);

        $notZipCodeCondition=[];
        $agentsInfo=[];
        try{
            DB::statement("SET foreign_key_checks=0");
            Agent::query()->truncate();
            DB::statement("SET foreign_key_checks=1");
        }
        catch(\Exception $e){
            $e->getMessage();
        }


        foreach ($request->inputs as $agents){

            array_push($notZipCodeCondition,$agents);
            try{
                $contact=Contact::where('code', '=', $agents)->first();

                $newAgent=new Agent();
                $newAgent->contact()->associate($contact->idContacts);
                $newAgent->save();
            }
            catch(\Exception $e){
                $e->getMessage();
            }

            array_push($agentsInfo,$newAgent);

        }
        try{
            $contacts=Contact::select('*')->whereNotIn('code', $notZipCodeCondition)->get();
        }
        catch(\Exception $e){
            $e->getMessage();
        }
        $coloredAgents=[];

        foreach ($contacts as $keyContact => $valueContact) {
            $shortDistance=$this->highestValue;
            $bestAgent="";
            foreach ($agentsInfo as $keyAgent => $valueAgent){

                $distanceWithAgent=$this->vincentyGreatCircleDistance($valueContact["lat"],$valueContact["lng"],$valueAgent->contact->lat,$valueAgent->contact->lng);

                if($distanceWithAgent<$shortDistance){
                    $shortDistance=$distanceWithAgent;
                    $bestAgent=$valueAgent->idAgent;
                }
                array_push($coloredAgents,$valueAgent->contact->code);

            }
            try{
                $contact=Contact::where('idContacts', $valueContact["idContacts"])->firstOrFail();
                $contact->idAgent=$bestAgent;
                $contact->save();
            }
            catch(\Exception $e){
                $e->getMessage();
            }

        }

//        print_r($agentsInfo[1]->contact()->count());

//        if(empty($request->umbral)){
//            $request->umbral=0;
//        }
//        if(ZipCode::where(['agentId' => 1])->get()->count()==0){
//            $this->getLessDistanceForUmbral($contacts,$request->umbral,$agent1,1);
//        }
//        if(ZipCode::where(['agentId' => 2])->get()->count()==0){
//            $this->getLessDistanceForUmbral($contacts,$request->umbral,$agent2,2);
//        }
//
        try{
            $results=Contact::all();
        }
        catch(\Exception $e){
            $e->getMessage();
        }



        return view('results',[
            'results'=>$results,
            'agents'=>$coloredAgents
        ]);
    }

    /**
     * Process the .CSV file and store it in the database
     */
    public function proccessCSV(){

        try{
            Facades\Excel::load('dataContacts.csv', function($reader) {

                // Getting all results
                $data = $reader->get();

                foreach ($data as $key => $value) {


                    $user = Contact::where('code', $value["zipcode"])->get();



                    if ($user->isEmpty()){

                        $zipCode= new Contact();

                        $zipCode->name=$value["name"];

                        $zipCode->code=$value["zipcode"];

//                        $valuesLatLng=$this->zipCodeToLngLat($zipCode->code);
//
//                        $zipCode->lat=$valuesLatLng["lat"];
//                        $zipCode->lng=$valuesLatLng["lng"];

                        $zipCode->save();


                    }
                }
            });
        }catch (\Exception $e){
            $e->getMessage();
        }

    }

    /**
     * Build an array with the latitude and longitude from a zip code using google API
     * @param $zipcode
     * @return array
     */
    protected function zipCodeToLngLat($zipcode){
        $client = new GuzzleHttp\Client;
        $res = $client->get('http://maps.googleapis.com/maps/api/geocode/json', ['query' =>  ['address' => $zipcode,'sensor'=>'true']]);
        $data=json_decode($res->getBody(), true);


        $lat=$data["results"][0]["geometry"]["location"]["lat"];
        $lng=$data["results"][0]["geometry"]["location"]["lng"];

        return array("lat"=>$lat,"lng"=>$lng);
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
    protected function vincentyGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
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
        return $angle * $this->earthRadius;
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
            try{
                DB::table('zipcodes')
                    ->where('code', $key)
                    ->update(['agentId' => $numberAgent]);
            }catch (\Exception $e){
                $e->getMessage();
            }

        }

    }
}
