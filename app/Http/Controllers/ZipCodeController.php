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

    public function index()
    {
//        echo "THIS: ".;
        $this->proccessCSV();
        return view('index');
    }

    public function truncate(){
        ZipCode::query()->truncate();
        return redirect()->route('index');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'zipCodeAngent1'=>'exists:zipcodes,code',
            'zipCodeAngent2'=>'exists:zipcodes,code',

        ]);
        $agent1=ZipCode::where('code', '=', $request->zipCodeAngent1)->first();
//        print_r($agent1->name);
        $agent2=ZipCode::where('code', '=', $request->zipCodeAngent2)->first();

        $contacts=ZipCode::where('code', '!=', $request->zipCodeAngent2)->where('code', '!=', $request->zipCodeAngent1)->get();
//        print_r($agent2->name);
//        echo "contactos:";
        foreach ($contacts as $key => $value) {
//            echo "{$key} => {$value} ";
//            echo "contacto: ".$value["name"]." zipcode: ".$value["code"];
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
//            echo "distanceAgent1: ".$distanceWithAgent1;
//            echo "distanceAgent2: ".$distanceWithAgent2;
//            echo "<br>";

//            print_r($contacts[$key]);
        }


        $results=ZipCode::all();
        return view('results',[
            'results'=>$results,
            'agent1'=>$agent1["code"],
            'agent2'=>$agent2["code"],
        ]);

//        $this->vincentyGreatCircleDistance(40.6892,-74.0444,48.8583,2.2945)
//        $agent1=ZipCode::$request->zipCodeAngent1;



    }

    public function show($zipCode)
    {
        print_r($this->zipCodeToLngLat($zipCode));
    }

    public function proccessCSV(){
        $data=null;
        Facades\Excel::load('testingMulu.csv', function($reader) {

            // Getting all results
//            $results = $reader->get();

            // ->all() is a wrapper for ->get() and will work the same
            $data = $reader->get();

//            print_r($results);
            foreach ($data as $key => $value) {
                // $arr[3] will be updated with each value from $arr...




                    //Do stuff when user exists.
                $user = ZipCode::where('code', $value["zipcode"])->get();


                if ($user->isEmpty()){
//                    $firstUser = $user->first()

                    $zipCode= new ZipCode();

                    $zipCode->name=$value["name"];

                    $zipCode->code=$value["zipcode"];

                    $valuesLatLng=$this->zipCodeToLngLat($zipCode->code);

                    $zipCode->lat=$valuesLatLng["lat"];
                    $zipCode->lng=$valuesLatLng["lng"];

                    $zipCode->save();
                    echo "nombre: ".$zipCode->name;
                    echo "zip: ".$zipCode->code;

                }



//                print_r($arr);
            }
        });


    }
    protected function getCSV(){

    }
    protected function zipCodeToLngLat($zipcode){
        $client = new GuzzleHttp\Client;
        $res = $client->get('http://maps.googleapis.com/maps/api/geocode/json', ['query' =>  ['address' => $zipcode,'sensor'=>'true']]);
        $data=json_decode($res->getBody(), true);


        $lat=$data["results"][0]["geometry"]["location"]["lat"];
        $lng=$data["results"][0]["geometry"]["location"]["lng"];

        return array("lat"=>$lat,"lng"=>$lng);
    }
    protected function midPoint($pointA,$pointB){
        $midPoint=($pointA+$pointB)/2;
        return $midPoint;
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
}
