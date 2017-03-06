<?php

namespace App\Http\Controllers;

use App\Library\ImageClass;
use App\Models\Content;
use App\Models\ContentCoverImageFile;
use App\Models\ContentFile;
use App\Models\Crop;
use eStatus;
use File;
use Illuminate\Http\Request;
use App\Library\imageInfoEx;
use Imagick;
use Redirect;
use Route;

class CropController extends Controller
{
    public $restful = true;
    private $errorPage = '';

    public function image(Request $request) {
        $cropSet = Crop::get();
        $contentID=$request->get("contentID");
        $contentFile = ContentFile::where('ContentID', '=', $contentID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentFileID', 'DESC')->first();

        if (!$contentFile) {
            return Redirect::to($this->errorPage);
        }

        $ccif = ContentCoverImageFile::where('ContentFileID', '=', $contentFile->ContentFileID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentCoverImageFileID', 'DESC')->first();
        if (!$ccif) {
            return Redirect::to($this->errorPage);
        }

        //bu contentin imageini bulalim....
        //calculate the absolute path of the source image
        $imagePath = $contentFile->FilePath . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION;
        $imageInfo = new imageInfoEx($imagePath);
        if (!$imageInfo->isValid()) {
            $imagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
            $imageInfo = new imageInfoEx($imagePath);
        }
        $data = array();
        $data['cropSet'] = $cropSet;
        $data['imageInfo'] = $imageInfo;
        $data['displayedWidth'] = ImageClass::CropPageWidth;
        return view('pages.cropview', $data);
    }

    public function save(Request $request) {

        $xCoordinateSet = $request->get("xCoordinateSet");
        $yCoordinateSet = $request->get("yCoordinateSet");
        $heightSet = $request->get("heightSet");
        $widthSet = $request->get("widthSet");
        $cropIDSet = $request->get("cropIDSet");
        $contentID = (int) $request->get("contentID", 0);

        /** @var ContentFile $contentFile */
        $contentFile = ContentFile::where('ContentID', '=', $contentID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentFileID', 'DESC')->first();
        if (!$contentFile) {
            return Redirect::to($this->errorPage);
        }

        /** @var ContentCoverImageFile $ccif */
        $ccif = ContentCoverImageFile::where('ContentFileID', '=', $contentFile->ContentFileID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentCoverImageFileID', 'DESC')
            ->first();

        if (!$ccif) {
            return Redirect::to($this->errorPage);
        }

        //bu contentin imageini bulalim....
        //calculate the absolute path of the source image
        $sourceImagePath = $contentFile->FilePath . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION;
        if (!File::exists(public_path($sourceImagePath))) {
            //old pdf files dont have an original.jpg
            $sourceImagePath = $contentFile->FilePath . "/" . $ccif->SourceFileName;
        }
        $imageInfo = new imageInfoEx($sourceImagePath);
        $fileSet = scandir(public_path($contentFile->FilePath . "/"));
        $length = strlen(IMAGE_CROPPED_NAME);
        foreach ($fileSet as $fileName) {
            if (substr($fileName, 0, $length) === IMAGE_CROPPED_NAME) {
                unlink(public_path($contentFile->FilePath . "/" . $fileName));
            }
        }

        for ($i = 0; $i < count($xCoordinateSet); $i++) {
            /** @var Crop $crop */
            $crop = Crop::find($cropIDSet[$i]);
            if (!$crop) {
                continue;
            }

            $RespectRatio = ($imageInfo->width / ImageClass::CropPageWidth);
            $im = new Imagick($imageInfo->absolutePath);
            $im->cropimage($widthSet[$i] * $RespectRatio, $heightSet[$i] * $RespectRatio, $xCoordinateSet[$i] * $RespectRatio, $yCoordinateSet[$i] * $RespectRatio);
            $im->resizeImage($crop->Width, $crop->Height, Imagick::FILTER_LANCZOS, 1, TRUE);
            $im->writeImage(public_path($contentFile->FilePath . "/" . IMAGE_CROPPED_NAME . "_" . $crop->Width . "x" . $crop->Height . ".jpg"));
            $im->destroy();
        }

        $content = Content::find($contentID);
        $content->CoverImageVersion++;
        $content->save();
        return Redirect::route('crop_image', ['contentID' => $contentID, 'success' => 'cropsaved']);
    }

}
