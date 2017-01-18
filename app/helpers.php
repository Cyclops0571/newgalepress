<?php

class localize {
    public function get() {
        return 'test';
    }

    function __toString()
    {
        return 'test';
    }
}

abstract class eStatus {
    const All = 0;
    const Active = 1;
    const Passive = 2;
    const Deleted = 3;
}

abstract class eDeviceType {
    const ios = 'ios';
    const android = 'android';
}

abstract class eRemoveFromMobile {
    const Active = 1;
    const Passive = 0;
}

abstract class eRequestType
{
    const NORMAL_IMAGE_FILE = 1101;
    const SMALL_IMAGE_FILE = 1102;
    const PDF_FILE = 1001;
}

abstract class eUserTypes
{
    const Manager = 101;
    const Customer = 111;
}

class eServiceError {

    const ServiceNotFound = 1;
    const IncorrectPassword = 101;
    const ContentNotFound = 102;
    const ContentBlocked = 103;
    const UserNotFound = 120;
    const ApplicationNotFound = 130;
    const PassiveApplication = 131;
    const IncorrectUserCredentials = 140;
    const CategoryNotFound = 150;
    const CreateAccount = 151;
    const ClientNotFound = 160;
    const ClientIncorrectPassword = 161;
    const ClientInvalidPasswordAttemptsLimit = 162;
    const GenericError = 400;

    const ContentNotFoundMessage = 'İçerik bulunamadı.';

    /**
     *
     * @param Int $errorNo
     * @return \Exception
     */
    public static function getException($errorNo, $errorMsg = "") {
        switch ($errorNo) {
            case eServiceError::ServiceNotFound:
                $exception = new Exception("Servis versiyonu hatalı", $errorNo);
                break;
            case eServiceError::IncorrectPassword:
                $exception = new Exception("Hatalı parola!", $errorNo);
                break;
            case eServiceError::ContentNotFound:
                $exception = new Exception(self::ContentNotFoundMessage, $errorNo);
                break;
            case eServiceError::ContentBlocked:
                $exception = new Exception("İçerik engellenmiş.", $errorNo);
                break;
            case eServiceError::UserNotFound:
                $exception = new Exception("Müşteri bulunamadı.", $errorNo);
                break;
            case eServiceError::ApplicationNotFound:
                $exception = new Exception("Uygulama bulunamadı.", $errorNo);
                break;
            case eServiceError::PassiveApplication:
                $exception = new Exception("Uygulama aktif değil. Uygulamanın süresi dolmuş, engellenmiş veya pasifleştirilmiş olabilir.", $errorNo);
                break;
            case eServiceError::IncorrectUserCredentials:
                $exception = new Exception("Hatalı Kullanıcı Bilgileri.", $errorNo);
                break;
            case eServiceError::CategoryNotFound:
                $exception = new Exception("Kategori bulunamadı.", $errorNo);
                break;
            case eServiceError::CreateAccount:
                $exception = new Exception(Config::get('custom.url') . " adresinden hesap oluşturmalısınız.", $errorNo);
                break;

            //client errors
            case eServiceError::ClientNotFound:
                $exception = new Exception("Kullanıcı Bulunamadı.", $errorNo);
                break;
            case eServiceError::ClientIncorrectPassword:
                $exception = new Exception("Hatalı parola girişi.", $errorNo);
                break;
            case eServiceError::ClientInvalidPasswordAttemptsLimit:
                $exception = new Exception("Hatalı parola giriş limitiniz doldu. Hesabınızın tekrar aktifleşmesi için 2 saat bekleyiniz.", $errorNo);
                break;
            case eServiceError::GenericError:
                $exception = new Exception($errorMsg, $errorNo);
                break;
            default:
                $exception = new Exception();
        }
        return $exception;
    }

}

class eTemplateColor
{
    private static $imageFolder = 'img/template-chooser/';
    private static $imageGeneratedFolder = 'img/template-generated/';

    private static $requiredImageSet = array(
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
    );

    public static function templateCss($fileName)
    {
        $templateColorCode = basename($fileName, '.css');
        foreach (self::$requiredImageSet as $requiredImageTmp) {
            $requiredImageWithPath = path('public') . self::$imageGeneratedFolder . str_replace('1', $templateColorCode, $requiredImageTmp);
            $origImgWithPath = path('public') . self::$imageFolder . $requiredImageTmp;
            if (!\Laravel\File::exists($requiredImageWithPath)) {
                exec("convert " . $origImgWithPath . ' -fuzz 90% -fill \'#' . $templateColorCode . '\' -opaque blue ' . $requiredImageWithPath);
            }
        }

        $fileContent = File::get(path('app') . "csstemplates/color.css");
        $fileContent = str_replace("#TemplateColor#", $templateColorCode, $fileContent);
        $fileContent = str_replace("#APP_VER#", APP_VER, $fileContent);
        return $fileContent;
    }

}


/**
 * Retrieve a language line.
 *
 * @param  string  $key
 * @param  array   $replacements
 * @param  string  $language
 * @return \Symfony\Component\Translation\TranslatorInterface|string
 */
function __($key, $replacements = array(), $language = null)
{
    return trans($key, $replacements, 'messages', $language);
}

function dj($value) {
    echo json_encode($value);
    die;
}

/**
 * Recursively remove slashes from array keys and values.
 *
 * @param  array  $array
 * @return array
 */
function array_strip_slashes($array)
{
    $result = array();

    foreach($array as $key => $value)
    {
        $key = stripslashes($key);

        // If the value is an array, we will just recurse back into the
        // function to keep stripping the slashes out of the array,
        // otherwise we will set the stripped value.
        if (is_array($value))
        {
            $result[$key] = array_strip_slashes($value);
        }
        else
        {
            $result[$key] = stripslashes($value);
        }
    }

    return $result;
}
