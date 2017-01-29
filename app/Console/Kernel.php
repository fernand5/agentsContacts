<?php

namespace App\Console;

use App\Contact;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use GuzzleHttp;
use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $client = new GuzzleHttp\Client;
            $zipcodes=Contact::all();
            foreach ($zipcodes as $key =>$value){
                echo $value["code"]."\n\n";
                $res = $client->get('http://maps.googleapis.com/maps/api/geocode/json', ['query' =>  ['address' => $value["code"],'sensor'=>'true']]);
                $data=json_decode($res->getBody(), true);

                $lat=$data["results"][0]["geometry"]["location"]["lat"];
                $lng=$data["results"][0]["geometry"]["location"]["lng"];

                    DB::table('contacts')
                        ->where('code', $value["code"])
                        ->update(['lat' => $lat,'lng'=>$lng]);
                sleep(1);
            }
        })->everyMinute();
    }
}
