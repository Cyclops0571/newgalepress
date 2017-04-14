<?php


namespace App\Library;

use File;

class TemplateColor {

    private static $imageFolder = 'img/template-chooser/';
    private static $imageGeneratedFolder = 'img/template-generated/';

    private static $requiredImageSet = [
        'menu1.png',
        'home_selected1.png',
        'library_selected1.png',
        'download_selected1.png',
        'info_selected1.png',
        'left_menu_category_icon1.png',
        'left_menu_down1.png',
        'left_menu_link1.png',
        'reader_menu1.png',
        'reader_share1.png',
    ];

    public static function templateCss($fileName)
    {
        $templateColorCode = basename($fileName, '.css');
        if(!File::isDirectory(self::$imageGeneratedFolder)) {
            File::makeDirectory(self::$imageGeneratedFolder);
        }
        if(!File::isDirectory(self::$imageFolder)) {
            File::makeDirectory(self::$imageFolder);
        }
        foreach (self::$requiredImageSet as $requiredImageTmp)
        {
            $requiredImageWithPath = public_path(self::$imageGeneratedFolder . str_replace('1', $templateColorCode, $requiredImageTmp));
            $origImgWithPath = public_path(self::$imageFolder . $requiredImageTmp);
            if (!File::exists($requiredImageWithPath))
            {
                exec("convert " . $origImgWithPath . ' -fuzz 90% -fill \'#' . $templateColorCode . '\' -opaque blue ' . $requiredImageWithPath);
            }
        }

        $fileContent = File::get(resource_path("templates/color.css"));
        $fileContent = str_replace("#TemplateColor#", $templateColorCode, $fileContent);
        $fileContent = str_replace("#APP_VER#", APP_VER, $fileContent);

        return $fileContent;
    }

}