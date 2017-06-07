<?php

namespace App\Jobs;

use App\Models\PushNotificationDevice;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PushNotification implements ShouldQueue {

    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }



    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        ob_end_flush();
        //https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Introduction.html
        //https://developer.apple.com/library/ios/technotes/tn2265/_index.html
        while (PushNotificationDevice::isUnsentNotificationExists())
        {
            if (!isset($consoleLog))
            {
                $consoleLog = new ConsoleLog(__CLASS__, "Push Notification");
                $consoleLog->save();
            }

            mobileService::androidInternal($tempPND->PushNotification);
            mobileService::iosInternal($tempPND->PushNotification);
        }

    }


    public function iosInternal($cert, $message, $deviceToken)
    {
        //at dunyasi - ApplicationID: 592 CustomerID: 599
        //serdar saygili iphone device token: 53599c08189c13e53faec9f6842808d14b0195fc775b02c7e78481741b7be076
        $success = false;

        // Put your private key's passphrase here:
        $passphrase = Config::get('custom.passphrase');


        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client(
            'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

        if ($fp)
        {
            // Create the payload body
            $body['aps'] = [
                'alert' => $message,
                'sound' => 'default',
            ];

            // Encode the payload as JSON
            $payload = json_encode($body);

            // Build the binary notification
            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

            // Send it to the server
            $result = fwrite($fp, $msg, strlen($msg));


            if ($result)
            {
                $success = true;
            }
            // Close the connection to the server
            fclose($fp);
        } else
        {
            //throw new Exception("Failed to connect: $err $errstr" . PHP_EOL);
        }

        return $success;
    }

    public function androidInternal($message, $deviceToken)
    {
        $success = false;
        $googleAPIKey = Config::get('custom.google_api_key');

        $data = [
            'headers' => [
                'Authorization: key=' . $googleAPIKey,
                'Content-Type: application/json',
            ],
            'fields'  => [
                'registration_ids' => [
                    $deviceToken,
                ],
                'data'             => [
                    "message" => $message,
                ],
            ],
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://gcm-http.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data['headers']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['fields']));
        $response = curl_exec($ch);
        if ($response === false)
        {
            //die('Curl failed: ' . curl_error($ch));
            throw new Exception('Curl failed: ' . curl_error($ch));
        } else
        {
            $responseArray = json_decode($response, true);
            if (isset($responseArray['success']) && $responseArray['success'] == 1)
            {
                $success = true;
            }

            if (isset($responseArray['results']))
            {
                foreach ($responseArray['results'] as $result)
                {
                    if (isset($result['registration_id']))
                    {
                        $cannonicalToken = $result['registration_id'];
                        if ($deviceToken != $cannonicalToken)
                        {
                            //eger deviceToken degismis ise eski deviceToken ile tekrardan pushNotification yollama...
                            $token = Token::where('DeviceToken',  $deviceToken)->first();
                            $token instanceof Token;
                            $token->StatusID = eStatus::Deleted;
                            $token->save();
                        }
                    }
                }
            }
        }
        curl_close($ch);

        return $success;
    }

    public function ios($args)
    {
        return;
        $applicationID = $args[0];
        $message = $args[1];
        $deviceToken = $args[2];

        $app = DB::table('Application')
            ->where('ApplicationID',  (int)$applicationID)
            ->first();
        if (!$app)
        {
            throw new Exception('Application not found!');
        }
        $cert = path('public') . 'files/customer_' . $app->CustomerID . '/application_' . $app->ApplicationID . '/' . $app->CkPem;
        echo $this->iosInternal($cert, $message, $deviceToken);
    }

    public function android($args)
    {
        return;
        $applicationID = $args[0];
        $message = $args[1];
        $deviceToken = $args[2];
        echo $this->androidInternal($message, $deviceToken);
    }

    public function run_backup()
    {
        //https://developer.apple.com/library/ios/documentation/NetworkingInternet/Conceptual/RemoteNotificationsPG/Introduction.html
        //https://developer.apple.com/library/ios/technotes/tn2265/_index.html
        try
        {
            $pn = DB::table('Customer AS c')
                ->join('Application AS a', function ($join)
                {
                    $join->on('a.CustomerID',  'c.CustomerID');
                    $join->on('a.StatusID',  DB::raw(eStatus::Active));
                })
                ->join('PushNotification AS p', function ($join)
                {
                    $join->on('p.CustomerID',  'c.CustomerID');
                    $join->on('p.ApplicationID',  'a.ApplicationID');
                    $join->on('p.StatusID',  DB::raw(eStatus::Active));
                })
                ->join('PushNotificationDevice AS d', function ($join)
                {
                    $join->on('d.PushNotificationID',  'p.PushNotificationID');
                    $join->on('d.Sent',  DB::raw(0));
                    $join->on('d.ErrorCount', '<', DB::raw(2));
                    $join->on('d.StatusID',  DB::raw(eStatus::Active));
                })
                /*
                  ->where(function($query)
                  {
                  $query->where_null('d.ErrorCount');
                  $query->or_where('d.ErrorCount', '<', 2);
                  })
                 */
                ->where('c.StatusID', eStatus::Active)
                ->order_by('p.PushNotificationID', 'DESC')
                ->order_by('d.PushNotificationDeviceID', 'DESC')
                ->take(1000)
                ->get(['c.CustomerID', 'a.ApplicationID', 'a.CkPem', 'p.PushNotificationID', 'p.NotificationText', 'd.PushNotificationDeviceID', 'd.DeviceToken', 'd.DeviceType']);

            foreach ($pn as $n)
            {
                try
                {
                    //ios
                    if ($n->DeviceType === 'ios')
                    {
                        $cert = path('public') . 'files/customer_' . $n->CustomerID . '/application_' . $n->ApplicationID . '/' . $n->CkPem;

                        // Put your device token here (without spaces):
                        $deviceToken = $n->DeviceToken;

                        // Put your private key's passphrase here:
                        $passphrase = Config::get('custom.passphrase');

                        // Put your alert message here:
                        $message = $n->NotificationText;


                        $ctx = stream_context_create();
                        stream_context_set_option($ctx, 'ssl', 'local_cert', $cert);
                        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

                        // Open a connection to the APNS server
                        $fp = stream_socket_client(
                            'ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);

                        if ($fp)
                        {
                            // Create the payload body
                            $body['aps'] = [
                                'alert' => $message,
                                'sound' => 'default',
                            ];

                            // Encode the payload as JSON
                            $payload = json_encode($body);

                            // Build the binary notification
                            $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

                            // Send it to the server
                            $result = fwrite($fp, $msg, strlen($msg));


                            if ($result)
                            {
                                //echo 'Message successfully delivered' . PHP_EOL;
                                $c = PushNotificationDevice::find((int)$n->PushNotificationDeviceID);
                                $c->Sent = 1;
                                $c->save();
                            } else
                            {
                                $c = PushNotificationDevice::find((int)$n->PushNotificationDeviceID);
                                $c->ErrorCount = (int)$c->ErrorCount + 1;
                                $c->LastErrorDetail = 'Message not delivered!';
                                $c->save();
                            }
                            // Close the connection to the server
                            fclose($fp);
                        } else
                        {
                            //throw new Exception("Failed to connect: $err $errstr" . PHP_EOL);
                        }
                    } //android
                    elseif ($n->DeviceType === 'android')
                    {
                        $googleAPIKey = Config::get('custom.google_api_key');

                        $data = [
                            'headers' => [
                                'Authorization: key=' . $googleAPIKey,
                                'Content-Type: application/json',
                            ],
                            'fields'  => [
                                'registration_ids' => [
                                    $n->DeviceToken,
                                ],
                                'data'             => [
                                    "message" => $n->NotificationText,
                                ],
                            ],
                        ];
                        //}

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $data['headers']);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Disabling SSL Certificate support temporarly
                        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data['fields']));
                        $result = curl_exec($ch);
                        if ($result === false)
                        {
                            //die('Curl failed: ' . curl_error($ch));
                            throw new Exception('Curl failed: ' . curl_error($ch));
                        }
                        curl_close($ch);
                        $json = json_decode($result, true);
                        if ($json['success'] === 1)
                        {
                            $c = PushNotificationDevice::find((int)$n->PushNotificationDeviceID);
                            $c->Sent = 1;
                            $c->save();
                        } else
                        {
                            $c = PushNotificationDevice::find((int)$n->PushNotificationDeviceID);
                            $c->ErrorCount = (int)$c->ErrorCount + 1;
                            $c->LastErrorDetail = 'Message not delivered!';
                            $c->save();
                        }
                    }
                } catch (Exception $e)
                {
                    $c = PushNotificationDevice::find((int)$n->PushNotificationDeviceID);
                    $c->ErrorCount = (int)$c->ErrorCount + 1;
                    $c->LastErrorDetail = $e->getMessage();
                    $c->save();
                }
            }
        } catch (Exception $e)
        {
            $msg = __('common.task_message', [
                    'task'   => '`PushNotification`',
                    'detail' => $e->getMessage(),
                ]
            );

            Common::sendErrorMail($msg);
        }
    }
}
