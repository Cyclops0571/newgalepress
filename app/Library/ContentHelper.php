<?php

namespace App\Library;


use App\Models\Application;
use App\Models\Content;
use App\Models\ContentFile;
use App\Models\ContentFilePage;
use App\Models\PageComponent;
use App\Models\PageComponentProperty;
use DateTime;
use eProcessTypes;
use eStatus;
use File;
use Interactivity;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class ContentHelper {

    /**
     * @param $destinationFolder
     * @param $sourceContentID
     * @param $targetContentID
     * @param $targetContentFileID
     * @return string|void
     */
    public static function copyContent($destinationFolder, $sourceContentID, $targetContentID, $targetContentFileID)
    {
        // /***** HEDEF CONTENTIN SAYFALARI OLUSUTURLMUS OLMALI YANI INTERAKTIF TASARLAYICISI ACILMIS OLMALI!!!*****/
        // TAŞINACAK CONTENT'IN FILE ID'SI
        $contentFile = ContentFile::where('ContentID', '=', $sourceContentID)
            ->orderBy('ContentFileID', 'DESC')
            ->first();

        $contentFilePage = ContentFilePage::where('ContentFileID', '=', $contentFile->ContentFileID)
            ->get();

        if (sizeof($contentFilePage) == 0)
        {
            return;
        } else
        {

            $contentFilePageNewCount = ContentFilePage::where('ContentFileID', '=', $targetContentFileID)
                ->count();

            $targetApplicationID = Content::where('ContentID', '=', $targetContentID)->first();

            $targetCustomerID = Application::where('ApplicationID', '=', $targetApplicationID->ApplicationID)->first();

            if ($destinationFolder != "null")
            { /* kopyalanacak icerigin sayfalari yok ise olusturur */
                foreach ($contentFilePage as $ocfp)
                {
                    $ncfp = new ContentFilePage();
                    $ncfp->ContentFileID = (int)$targetContentFileID;
                    $ncfp->No = (int)$ocfp->No;
                    $ncfp->Width = (int)$ocfp->Width;
                    $ncfp->Height = (int)$ocfp->Height;
                    $ncfp->FilePath = (string)'files/customer_' . $targetCustomerID->CustomerID . '/application_' . $targetApplicationID->ApplicationID . '/content_' . $targetContentID . '/file_' . $targetContentFileID;
                    $ncfp->FileName = (string)$ocfp->FileName;
                    $ncfp->FileName2 = (string)$ocfp->FileName2;
                    $ncfp->FileSize = (int)$ocfp->FileSize;
                    $ncfp->StatusID = (int)$ocfp->StatusID;
                    $ncfp->CreatorUserID = (int)$ocfp->CreatorUserID;
                    $ncfp->DateCreated = new DateTime();
                    $ncfp->ProcessUserID = $ocfp->CreatorUserID;
                    $ncfp->ProcessDate = new DateTime();
                    $ncfp->ProcessTypeID = eProcessTypes::Insert;
                    $ncfp->save();
                }
                if (!File::exists($destinationFolder . '/file_' . $targetContentFileID))
                {
                    File::makeDirectory($destinationFolder . '/file_' . $targetContentFileID);
                }

                $files = glob('public/' . $contentFile->FilePath . '/file_' . $contentFile->ContentFileID . '/*.{jpg,pdf}', GLOB_BRACE);
                foreach ($files as $file)
                {
                    File::copy('public/' . $contentFile->FilePath . '/file_' . $contentFile->ContentFileID . '/' . basename($file), $destinationFolder . '/file_' . $targetContentFileID . '/' . basename($file));
                }
            }

            foreach ($contentFilePage as $cfp)
            {


                $filePageComponent = PageComponent::where('ContentFilePageID', '=', $cfp->ContentFilePageID)->get();

                if (sizeof($filePageComponent) == 0)
                {
                    continue;
                }

                //HANGI CONTENT'E TASINACAKSA O CONTENT'IN FILE ID'SI
                $contentFilePageNew = ContentFilePage::where('ContentFileID', '=', $targetContentFileID)
                    ->where('No', $cfp->No)
                    ->first();

                if (isset($contentFilePageNew))
                {
                    foreach ($filePageComponent as $fpc)
                    {
                        $s = new PageComponent();
                        $s->ContentFilePageID = $contentFilePageNew->ContentFilePageID;
                        $s->ComponentID = $fpc->ComponentID;
                        if ($destinationFolder == "null")
                        {
                            $lastComponentNo = PageComponent::where('ContentFilePageID', $contentFilePageNew->ContentFilePageID)->max('No');
                            if ($lastComponentNo == null)
                            {
                                $lastComponentNo = 0;
                            }
                            $s->No = $lastComponentNo + 1;
                        } else
                        {
                            $s->No = $fpc->No;
                        }
                        // Log::info(serialize($ids));
                        $s->StatusID = eStatus::Active;
                        $s->DateCreated = new DateTime();
                        $s->ProcessDate = new DateTime();
                        $s->ProcessTypeID = eProcessTypes::Insert;
                        $s->save();

                        $filePageComponentProperties = PageComponentProperty::where('PageComponentID', '=', $fpc->PageComponentID)->get();

                        foreach ($filePageComponentProperties as $filePageComponentProperty)
                        {
                            $p = new PageComponentProperty();
                            $p->PageComponentID = $s->PageComponentID;
                            $p->Name = $filePageComponentProperty->Name;
                            if ($filePageComponentProperty->Value > $contentFilePageNewCount && $filePageComponentProperty->Name == "page")
                            {
                                $p->Value = 1;
                            } elseif ($filePageComponentProperty->Name == "filename")
                            {
                                $targetPath = 'files/customer_' . $targetCustomerID->CustomerID . '/application_' . $targetApplicationID->ApplicationID . '/content_' . $targetContentID . '/file_' . $targetContentFileID . '/output/comp_' . $s->PageComponentID;
                                $targetPathFull = public_path($targetPath);
                                $p->Value = $targetPath . '/' . basename($filePageComponentProperty->Value);
                                if (!File::exists($targetPathFull))
                                {
                                    File::makeDirectory($targetPathFull);
                                }
                                $files = glob('public/' . dirname($filePageComponentProperty->Value) . '/*.{jpg,JPG,png,PNG,tif,TIF,mp3,MP3,m4v,M4V,mp4,MP4,mov,MOV}', GLOB_BRACE);
                                foreach ($files as $file)
                                {
                                    File::copy($file, $targetPathFull . '/' . basename($file));
                                }
                            } else
                            {
                                $p->Value = $filePageComponentProperty->Value;
                            }
                            $p->StatusID = eStatus::Active;
                            $p->DateCreated = new DateTime();
                            $p->ProcessDate = new DateTime();
                            $p->ProcessTypeID = eProcessTypes::Insert;
                            $p->save();
                        }
                    }
                }
            }
        }

        $targetHasCreated = ContentFile::find($targetContentFileID);
        if ($targetHasCreated)
        {
            $targetHasCreated->Interactivity = Interactivity::ProcessQueued;
            $targetHasCreated->HasCreated = 0;
            $targetHasCreated->save();
        }

        self::interactivityQueue();
    }


    public static function interactivityQueue()
    {

	    $connection = new AMQPStreamConnection('localhost', 5672, 'galepress', 'galeprens');
	    $channel = $connection->channel();
	    $channel->queue_declare('queue_interactivepdf', false, false, false, false);
	    $msg = new AMQPMessage('Interactivity Start Progress!');
	    $channel->basic_publish($msg, '', 'queue_interactivepdf');
	    $channel->close();
	    $connection->close();
    }

}