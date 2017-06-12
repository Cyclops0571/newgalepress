<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Models\Content;
use App\Models\ContentFile;
use App\Models\Customer;
use Common;
use File;
use Illuminate\Console\Command;

class CalculateStorageUsageCommand extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zz-my-tasks:calculate-storage-usages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates the total storage usage of the customers.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $arr = [];

        $cs = Customer::all();
        foreach ($cs as $c)
        {
            foreach ($c->Application as $app)
            {
                /** @var Application $app */
                $contents = $app->Contents;
                foreach ($contents as $content)
                {
                    foreach ($content->ContentFile as $cf)
                    {
                        $size = 0;
                        $path = public_path('files/customer_' . $c->CustomerID . '/application_' . $app->ApplicationID . '/content_' . $content->ContentID . '/file_' . $cf->ContentFileID);
                        if (File::exists($path))
                        {
                            $size = Common::dirsize($path);
                        }
                        array_push($arr, ['contentfile', $cf->ContentFileID, $size]);
                    }
                    //each content
                    $size = 0;
                    $path = public_path('files/customer_' . $c->CustomerID . '/application_' . $app->ApplicationID . '/content_' . $content->ContentID);
                    if (File::exists($path))
                    {
                        $size = Common::dirsize($path);
                    }
                    array_push($arr, ['content', $content->ContentID, $size]);
                }
                //each application;
                $size = 0;
                $path = public_path('files/customer_' . $c->CustomerID . '/application_' . $app->ApplicationID);
                if (File::exists($path))
                {
                    $size = Common::dirsize($path);
                }
                array_push($arr, ['application', $app->ApplicationID, $size]);
            }
            //each customer;
            $size = 0;
            $path = public_path('files/customer_' . $c->CustomerID);
            if (File::exists($path))
            {
                $size = Common::dirsize($path);
            }
            array_push($arr, ['customer', $c->CustomerID, $size]);
        }

        foreach ($arr as $a)
        {
            if ($a[0] == 'customer')
            {
                $c = Customer::find((int)$a[1]);
                $c->TotalFileSize = (int)$a[2];
                $c->save();
            } elseif ($a[0] == 'application')
            {
                $c = Application::find((int)$a[1]);
                $c->TotalFileSize = (int)$a[2];
                $c->save();
            } elseif ($a[0] == 'content')
            {
                $c = Content::find((int)$a[1]);
                $c->TotalFileSize = (int)$a[2];
                $c->save();
            } elseif ($a[0] == 'contentfile')
            {
                $c = ContentFile::find((int)$a[1]);
                $c->TotalFileSize = (int)$a[2];
                $c->save();
            }
        }

    }
}
