<?php

namespace App\Console\Commands;

use App\Models\Statistic;
use Exception;
use Illuminate\Console\Command;
use Log;

class UpdateLocationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz-my-tasks:update-location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update mobile users location which are in the statistics table';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        //572572
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        ob_end_flush();
        for ($i = 0; $i < 90; $i++) {
            try {
                $apiRequest = 0;
                $statistics = Statistic::whereNotNull('Lat')
                    ->whereNotNull('Long')
                    ->where('Lat', '!=', 0)
                    ->where('Long', '!=', 0)
                    ->where('Lat', '!=', '')
                    ->where('Long', '!=', '')
                    ->whereNull('Country')
                    ->orderBy('StatisticID', 'DESC')
                    ->take(100)
                    ->get();
                echo "current chunk of statistic: " . $i * 100, PHP_EOL;
                foreach ($statistics as $statistic) {
                    if ((float)$statistic->Lat > 0 && (float)$statistic->Long > 0) {
                        echo "\t total api request count: " . $apiRequest, PHP_EOL;

                        $country = '';
                        $city = '';
                        $district = '';
                        $quarter = '';
                        $avenue = '';

                        $apiKey = config('custom.google_api_key');
                        $apiUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
                        $url = sprintf('%s?latlng=%s,%s&sensor=false&key=%s',
                            $apiUrl,
                            $statistic->Lat,
                            $statistic->Long,
                            $apiKey
                        );

                        $ch = curl_init($url);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $response = curl_exec($ch);
                        $apiRequest += 1;
                        curl_close($ch);

                        $json = json_decode($response, true);
                        if ($json["status"] == "OK") {
                            $results = $json["results"];
                            foreach ($results as $result) {
                                $addresses = $result["address_components"];
                                foreach ($addresses as $address) {
                                    $types = $address["types"];

                                    if (in_array("country", $types) && empty($country)) {
                                        $country = $address["long_name"];
                                    } else if (in_array("locality", $types) && empty($city)) {
                                        $city = $address["long_name"];
                                    } else if (in_array("sublocality", $types) && empty($district)) {
                                        $district = $address["long_name"];
                                    } else if (in_array("neighborhood", $types) && empty($quarter)) {
                                        $quarter = $address["long_name"];
                                    } else if (in_array("route", $types) && empty($avenue)) {
                                        $avenue = $address["long_name"];
                                    }
                                }
                            }
                        }


                        $statistic->Country = $country;
                        $statistic->City = $city;
                        $statistic->District = $district;
                        $statistic->Quarter = $quarter;
                        $statistic->Avenue = $avenue;
                        $statistic->save();
                    } else {
                        Log::warning("Can not locate specified latitude & longitude. Id=" . $statistic->StatisticID);
                    }
                }
            } catch (Exception $e) {
                $msg = __('common.task_message', array(
                        'task' => '`UpdateLocation`',
                        'detail' => $e->getMessage()
                    )
                );
                Log::error($msg);
            }
        }
    }
}
