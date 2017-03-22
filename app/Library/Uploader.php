<?php


namespace App\Library;

use Exception;
use File;
use Imagick;
use ZipArchive;

class Uploader {

    /**
     * @desc creates a zip file from the uploaded url and creates first page.
     * @param $pdfFile
     * @return array
     */
    public static function ContentsUploadFile($pdfFile)
    {
        $filePath = public_path('files/temp');
        if (File::extension($filePath . '/' . $pdfFile) != 'pdf')
        {
            return [
                'fileName'  => "",
                'imageFile' => "",
            ];
        }

        //create zip archive
        $tempPdfFile = uniqid() . '.pdf';
        File::move($filePath . '/' . $pdfFile, $filePath . '/' . $tempPdfFile);
        $zipFile = $tempPdfFile . '.zip';

        $zip = new ZipArchive();
        $res = $zip->open($filePath . '/' . $zipFile, ZIPARCHIVE::CREATE);
        if ($res === true)
        {
            $zip->addFile($filePath . '/' . $tempPdfFile, 'file.pdf');
            $zip->close();
        }

        //create snapshot
        $imageFile = $tempPdfFile . '.jpg';
        $imageFileOriginal = $tempPdfFile . IMAGE_ORJ_EXTENSION;

        //create image with ghostscript from file
        //then use imagick
        $tempImageFile = uniqid() . ".jpg";

        $gsCommand = [];
        $gsCommand[] = 'gs';
        $gsCommand[] = '-o ' . $filePath . "/" . $tempImageFile;
        $gsCommand[] = '-sDEVICE=jpeg';
        $gsCommand[] = '-sPAPERSIZE=a1';
        $gsCommand[] = '-dUseCropBox';
        $gsCommand[] = '-dFirstPage=1';
        $gsCommand[] = '-dLastPage=1';
        $gsCommand[] = '-dJPEGQ=100';
        $gsCommand[] = '-r72x72';
        $gsCommand[] = "'" . $filePath . "/" . $tempPdfFile . "'";

        //	    echo implode(" ", $gsCommand), PHP_EOL;
        shell_exec(implode(" ", $gsCommand));
        $im = new Imagick($filePath . "/" . $tempImageFile);

        //convert color space to RGB
        //http://php.net/manual/en/imagick.setimagecolorspace.php
        if ($im->getImageColorspace() == Imagick::COLORSPACE_CMYK)
        {

            $profiles = $im->getImageProfiles('*', false);

            // we're only interested if ICC profile(s) exist
            $has_icc_profile = (array_search('icc', $profiles) !== false);

            // if it doesnt have a CMYK ICC profile, we add one
            if ($has_icc_profile === false)
            {
                //$icc_cmyk = file_get_contents(dirname(__FILE__).'/USWebUncoated.icc');
                $icc_cmyk = file_get_contents(public_path('files/icc/USWebUncoated.icc'));
                $im->profileImage('icc', $icc_cmyk);
                unset($icc_cmyk);
            }

            // then we add an RGB profile - 'AdobeRGB1998.icc'
            //$icc_rgb = file_get_contents(dirname(__FILE__).'/sRGB_v4_ICC_preference.icc');
            $icc_rgb = file_get_contents(public_path('files/icc/AdobeRGB1998.icc'));
            $im->profileImage('icc', $icc_rgb);
            unset($icc_rgb);

            $im->stripImage(); // this will drop down the size of the image dramatically (removes all profiles)
        }

        $im->resampleImage(72, 72, Imagick::FILTER_BOX, 1);
        $im->setCompression(Imagick::COMPRESSION_JPEG);
        $im->setCompressionQuality(80);
        $im->setImageFormat('jpg');
        $im->writeImage($filePath . '/' . $imageFileOriginal);


        $width = 400;
        $height = 524;
        $geo = $im->getImageGeometry();

        if (($geo['width'] / $width) < ($geo['height'] / $height))
        {
            $im->cropImage($geo['width'], floor($height * $geo['width'] / $width), 0, (($geo['height'] - ($height * $geo['width'] / $width)) / 2));
        } else
        {
            $im->cropImage(ceil($width * $geo['height'] / $height), $geo['height'], (($geo['width'] - ($width * $geo['height'] / $height)) / 2), 0);
        }
        $im->ThumbnailImage($width, $height, true);
        $im->writeImage($filePath . '/' . $imageFile);
        $im->clear();
        $im->destroy();
        unset($im);

        //delete pdf file
        File::delete($filePath . '/' . $tempPdfFile);
        if (!empty($tempImageFile) && File::exists($filePath . '/' . $tempImageFile))
        {
            File::delete($filePath . '/' . $tempImageFile);
        }

        $tempPdfFile = $zipFile;

        return [
            'fileName'  => $tempPdfFile,
            'imageFile' => $imageFile,
        ];
    }

    public static function CmykControl($tempFile)
    {
        $filePath = public_path('files/temp/');
        if (File::extension($filePath . "/" . $tempFile) == "gif")
        {
            return;
        }

        $im = new Imagick();
        $im->readImage($filePath . "/" . $tempFile);

        //convert color space to RGB
        //http://php.net/manual/en/imagick.setimagecolorspace.php
        if ($im->getImageColorspace() == Imagick::COLORSPACE_CMYK)
        {

            $profiles = $im->getImageProfiles('*', false);

            // we're only interested if ICC profile(s) exist
            $has_icc_profile = (array_search('icc', $profiles) !== false);

            // if it doesnt have a CMYK ICC profile, we add one
            if ($has_icc_profile === false)
            {
                //$icc_cmyk = file_get_contents(dirname(__FILE__).'/USWebUncoated.icc');
                $icc_cmyk = file_get_contents(public_path('files/icc/USWebUncoated.icc'));
                $im->profileImage('icc', $icc_cmyk);
                unset($icc_cmyk);
            }

            // then we add an RGB profile - 'AdobeRGB1998.icc'
            //$icc_rgb = file_get_contents(dirname(__FILE__).'/sRGB_v4_ICC_preference.icc');
            $icc_rgb = file_get_contents(public_path('files/icc/AdobeRGB1998.icc'));
            $im->profileImage('icc', $icc_rgb);
            unset($icc_rgb);

            $im->stripImage(); // this will drop down the size of the image dramatically (removes all profiles)
            $im->writeImage($filePath . '/' . $tempFile);
        }
        $im->clear();
        $im->destroy();
        unset($im);
    }

    public static function OrdersUploadFile($tempFile, $type)
    {
        $filePath = public_path('files/temp/');

        if ($type == 'uploadpng1024x1024' || $type == 'uploadpng640x960' || $type == 'uploadpng640x1136' || $type == 'uploadpng1536x2048' || $type == 'uploadpng2048x1536')
        {
            $size = str_replace('uploadpng', '', $type);
            $arrSize = explode('x', $size);
            $width = (int)$arrSize[0];
            $height = (int)$arrSize[1];

            $im = new Imagick();
            $im->readImage($filePath . "/" . $tempFile);
            $geo = $im->getImageGeometry();
            $w = (int)$geo['width'];
            $h = (int)$geo['height'];
            $im->clear();
            $im->destroy();
            unset($im);

            if ($w != $width || $h != $height)
            {

                File::delete($filePath . "/" . $tempFile);

                throw new Exception('Invalid file dimension!');
            }
        }
    }

}
