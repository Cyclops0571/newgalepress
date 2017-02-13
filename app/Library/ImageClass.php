<?php


namespace App\Library\ImageClass;


use Exception;
use Imagick;

class ImageClass
{

    const CropPageWidth = 250;
    public $isValid = false;
    private $img_id;
    private $img_element_id;
    private $img_type_id;
    private $img_source;



    /**
     * Without loosing the aspect ratio crops the image from the middle then
     * resizes the image to the wanted height and width
     * @param string $sourceFile
     * @param string $destinationFolder
     * @param int $width
     * @param int $height
     * @param string $outputImageName
     * @param bool $addHeightWidth
     * @return string Absolute path of the image
     */
    public static function cropImage($sourceFile, $destinationFolder, $width, $height, $outputImageName = IMAGE_CROPPED_NAME, $addHeightWidth = TRUE)
    {
        $im = new Imagick($sourceFile);
        $im->setImageFormat("jpg");
        $geo = $im->getImageGeometry();

        if (($geo['width'] / $width) < ($geo['height'] / $height)) {
            $im->cropImage($geo['width'], floor($height * $geo['width'] / $width), 0, (($geo['height'] - ($height * $geo['width'] / $width)) / 2));
        } else {
            $im->cropImage(ceil($width * $geo['height'] / $height), $geo['height'], (($geo['width'] - ($width * $geo['height'] / $height)) / 2), 0);
        }
        $im->ThumbnailImage($width, $height, true);

        if (substr($destinationFolder, -1) != "/") {
            $destinationFolder = $destinationFolder . "/";
        }

        if ($addHeightWidth) {
            $imageAbsolutePath = $destinationFolder . $outputImageName . "_" . $width . "x" . $height . IMAGE_EXTENSION;
        } else {
            $imageAbsolutePath = $destinationFolder . $outputImageName . IMAGE_EXTENSION;
        }

        $im->writeImages($imageAbsolutePath, true);
        $im->clear();
        $im->destroy();
        unset($im);
        return $imageAbsolutePath;
    }


    public function imgID($imgID = null)
    {
        if ($imgID != null && (int)$imgID > 0) {
            $this->img_id = (int)$imgID;
        }
        return $this->img_id;
    }


    /**
     *
     * @param int $objectID
     * @return int ownerObjectID
     */
    public function imgObjectID($objectID = null)
    {
        if ($objectID != null && (int)$objectID > 0) {
            $this->img_element_id = (int)$objectID;
        }
        return $this->img_element_id;
    }

    /**
     *
     * @param int $typeID owner object type
     * @return int owner object type
     */
    public function imgType($typeID = null)
    {
        get_class();
        if ($typeID != null && (int)$typeID > 0) {
            $this->img_type_id = (int)$typeID;
        }
        return $this->img_type_id;
    }

    /**
     * @return string starts without a slash and finishes with a slash
     * @throws Exception
     */
    public function dateFolder()
    {
        $imageSourceSet = explode('/', $this->imgSource());
        if (count($imageSourceSet) != 7) {
            throw new Exception('Folder count doesnt match at file:' . __FILE__ . ' line: ' . __LINE__); //TODO: do a better exception class-just steal it
        }
        return $imageSourceSet[2] . '/' . $imageSourceSet[3] . '/' . $imageSourceSet[4] . '/';
    }

    public function imgSource($source = null)
    {
        if (!empty($source)) {
            $this->img_source = (int)$source;
        }
        return $this->img_source;
    }


}