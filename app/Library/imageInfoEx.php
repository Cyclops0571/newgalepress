<?php

namespace App\Library;

class imageInfoEx {
    const CropPageWidth = 250;
    public $width = 0;
    public $height = 0;
    public $type = "";
    public $attr = "";
    public $dir = "";
    public $absolutePath = "";
    public $webUrl = "";
    public $webDir = "";
    private $_isValid = FALSE;

    /**
     * @param string $inputFile absolute path to image
     */
    public function __construct($inputFile) {
        if (($imageSize = @getimagesize(public_path($inputFile))) !== false) {
            $this->_isValid = true;
            $this->width = $imageSize[0];
            $this->height = $imageSize[1];
            $this->type = $imageSize[2];
            $this->attr = $imageSize[3];
            $this->absolutePath = public_path($inputFile);
            $this->dir = pathinfo($this->absolutePath, PATHINFO_DIRNAME);
            $this->webUrl = "/" . $inputFile;
            $this->webDir = pathinfo($this->webUrl, PATHINFO_DIRNAME);
        }
    }

    public function isValid() {
        return $this->_isValid;
    }
}
