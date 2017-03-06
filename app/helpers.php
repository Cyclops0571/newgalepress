<?php

use App\Models\Application;
use App\Models\Content;
use App\Models\ContentFile;
use App\Models\Requestt;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Str;

class localize
{
    public function get()
    {
        return 'test';
    }

    function __toString()
    {
        return 'test';
    }
}

abstract class Interactivity
{
    const ProcessAvailable = 0;
    const ProcessQueued = 1;
    const ProcessContinues = 2;
}

abstract class eStatus
{
    const All = 0;
    const Active = 1;
    const Passive = 2;
    const Deleted = 3;
}

abstract class eDeviceType
{
    const ios = 'ios';
    const android = 'android';
}

abstract class eRemoveFromMobile
{
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

abstract class eProcessTypes
{
    const Insert = 51;
    const Update = 52;
    const Delete = 53;
}

class eServiceError
{

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
     * @param string $errorMsg
     * @return Exception
     */
    public static function getException($errorNo, $errorMsg = "")
    {
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
            $requiredImageWithPath = public_path(self::$imageGeneratedFolder . str_replace('1', $templateColorCode, $requiredImageTmp));
            $origImgWithPath = public_path(self::$imageFolder . $requiredImageTmp);
            if (!File::exists($requiredImageWithPath)) {
                exec("convert " . $origImgWithPath . ' -fuzz 90% -fill \'#' . $templateColorCode . '\' -opaque blue ' . $requiredImageWithPath);
            }
        }

        $fileContent = File::get(app_path("/csstemplates/color.css"));
        $fileContent = str_replace("#TemplateColor#", $templateColorCode, $fileContent);
        $fileContent = str_replace("#APP_VER#", APP_VER, $fileContent);
        return $fileContent;
    }

}

class Subscription
{
    const week = 1;
    const mounth = 2;
    const year = 3;

    public static function types()
    {
        return array(
            1 => "week_subscription",
            2 => "month_subscription",
            3 => "year_subscription",
        );
    }

}


/**
 * Retrieve a language line.
 *
 * @param  string $key
 * @param  array $replacements
 * @param  string $language
 * @return \Symfony\Component\Translation\TranslatorInterface|string
 */
function __($key, $replacements = array(), $language = null)
{
    return trans($key, $replacements, 'messages', $language);
}

function dj($value)
{
    echo json_encode($value);
    die;
}

/**
 * Recursively remove slashes from array keys and values.
 *
 * @param  array $array
 * @return array
 */
function array_strip_slashes($array)
{
    $result = array();

    foreach ($array as $key => $value) {
        $key = stripslashes($key);

        // If the value is an array, we will just recurse back into the
        // function to keep stripping the slashes out of the array,
        // otherwise we will set the stripped value.
        if (is_array($value)) {
            $result[$key] = array_strip_slashes($value);
        } else {
            $result[$key] = stripslashes($value);
        }
    }

    return $result;
}

class Common
{

    public static function htmlOddEven($name)
    {
        static $status = array();

        if (!isset($status[$name])) {
            $status[$name] = 0;
        }

        $status[$name] = 1 - $status[$name];
        return ($status[$name] % 2 == 0) ? 'even' : 'odd';
    }

    public static function dirsize($dir)
    {
        if (is_file($dir))
            return filesize($dir);
        if ($dh = opendir($dir)) {
            $size = 0;
            while (($file = readdir($dh)) !== false) {
                if ($file == '.' || $file == '..')
                    continue;
                $s = Common::dirsize($dir . '/' . $file);
                $size += $s;
            }
            closedir($dh);
            return $size;
        }
        return 0;
    }

    public static function xmlEscape($string)
    {
        return str_replace(array('&', '<', '>', '\'', '"'), array('&amp;', '&lt;', '&gt;', '&apos;', '&quot;'), $string);
    }

    public static function CheckCategoryOwnership($categoryID)
    {
        $currentUser = Auth::user();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $count = DB::table('Customer AS c')
                ->join('Application AS a', function (JoinClause $join) {
                    $join->on('a.CustomerID', '=', 'c.CustomerID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('Category AS t', function (JoinClause $join) use ($categoryID) {
                    $join->on('t.CategoryID', '=', DB::raw($categoryID));
                    $join->on('t.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('t.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where('c.CustomerID', '=', $currentUser->CustomerID)
                ->where('c.StatusID', '=', eStatus::Active)
                ->count();
            if ($count > 0) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    public static function CheckCategoryOwnershipWithApplication($applicationID, $categoryID)
    {
        $currentUser = Auth::user();

        $chk4Application = Common::CheckApplicationOwnership($applicationID);

        if ($chk4Application) {
            if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
                $count = DB::table('Customer AS c')
                    ->join('Application AS a', function (JoinClause $join) use ($applicationID) {
                        $join->on('a.ApplicationID', '=', DB::raw($applicationID));
                        $join->on('a.CustomerID', '=', 'c.CustomerID');
                        $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                    })
                    ->join('Category AS t', function (JoinClause $join) use ($categoryID) {
                        $join->on('t.CategoryID', '=', DB::raw($categoryID));
                        $join->on('t.ApplicationID', '=', 'a.ApplicationID');
                        $join->on('t.StatusID', '=', DB::raw(eStatus::Active));
                    })
                    ->where('c.CustomerID', '=', $currentUser->CustomerID)
                    ->where('c.StatusID', '=', eStatus::Active)
                    ->count();
                if ($count > 0) {
                    return true;
                }
            } else {
                $count = DB::table('Category')
                    ->where('CategoryID', '=', $categoryID)
                    ->where('ApplicationID', '=', $applicationID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->count();
                if ($count > 0) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function CheckApplicationOwnership($applicationID)
    {
        $currentUser = Auth::user();
        if ($currentUser == NULL) {
            return FALSE;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Manager) {
            return true;
        }

        if ((int)$applicationID == 0) {
            return FALSE;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $a = Application::find($applicationID);
            if ($a) {
                if ((int)$a->StatusID == eStatus::Active) {
                    $c = $a->Customer;
                    if ((int)$c->StatusID == eStatus::Active) {
                        if ((int)$currentUser->CustomerID == (int)$c->CustomerID) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public static function CheckContentPasswordOwnership($contentPasswordID)
    {
        $currentUser = Auth::user();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $count = DB::table('Customer AS c')
                ->join('Application AS a', function (JoinClause $join) {
                    $join->on('a.CustomerID', '=', 'c.CustomerID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('Content AS cn', function (JoinClause $join) {
                    $join->on('cn.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('cn.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('ContentPassword AS cp', function (JoinClause $join) use ($contentPasswordID) {
                    $join->on('cp.ContentPasswordID', '=', DB::raw($contentPasswordID));
                    $join->on('cp.ContentID', '=', 'cn.ContentID');
                    $join->on('cp.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where('c.CustomerID', '=', $currentUser->CustomerID)
                ->where('c.StatusID', '=', eStatus::Active)
                ->count();
            if ($count > 0) {
                return true;
            }
            return false;
        } else {
            return true;
        }
    }

    public static function AuthInteractivity($applicationID)
    {
        if (Common::CheckApplicationOwnership($applicationID)) {
            $a = Application::find($applicationID);
            if ($a) {
                return (1 == (int)$a->Package->Interactive);
            }
        }
        return false;
    }

    public static function AuthMaxPDF($applicationID)
    {
        if (Common::CheckApplicationOwnership($applicationID)) {
            $currentPDF = (int)Content::where('ApplicationID', '=', $applicationID)->where('Status', '=', 1)->where('StatusID', '=', eStatus::Active)->count();
            $maxPDF = 0;

            $a = Application::find($applicationID);
            if ($a) {
                $maxPDF = (int)Application::find($applicationID)->Package->MaxActivePDF;
                if ($currentPDF < $maxPDF) {
                    return true;
                }
            }
        }
        return false;
    }

    public static function getContentDetail($ContentID, $Password, &$oCustomerID, &$oApplicationID, &$oContentID, &$oContentFileID, &$oContentFilePath, &$oContentFileName)
    {
        $oCustomerID = 0;
        $oApplicationID = 0;
        $oContentID = 0;
        $oContentFileID = 0;
        $oContentFilePath = '';
        $oContentFileName = '';

        $c = DB::table('Customer AS c')
            ->join('Application AS a', function (JoinClause $join) {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->join('Content AS o', function (JoinClause $join) use ($ContentID) {
                $join->on('o.ContentID', '=', DB::raw($ContentID));
                $join->on('o.ApplicationID', '=', 'a.ApplicationID');
                $join->on('o.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->where('c.StatusID', '=', eStatus::Active)
            ->first(array('c.CustomerID', 'a.ApplicationID', 'o.ContentID', 'o.IsProtected'));
        if ($c) {
            $oCustomerID = (int)$c->CustomerID;
            $oApplicationID = (int)$c->ApplicationID;
            $oContentID = (int)$c->ContentID;
            $IsProtected = (int)$c->IsProtected;
            if ($IsProtected == 1) {
                //Content
                $authPwd = false;
                $checkPwd = DB::table('Content')
                    ->where('ContentID', '=', $oContentID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();
                if ($checkPwd) {
                    $authPwd = Hash::check($Password, $checkPwd->Password);
                }
                //Content password
                $authPwdList = false;
                $checkPwdList = DB::table('ContentPassword')
                    ->where('ContentID', '=', $oContentID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->get();
                if ($checkPwdList) {
                    foreach ($checkPwdList as $pwd) {
                        if ((int)$pwd->Qty > 0) {
                            if (Hash::check($Password, $pwd->Password)) {
                                $authPwdList = true;
                                //dec counter
                                $current = ContentPassword::find($pwd->ContentPasswordID);
                                if ((int)$current->Qty > 0) {
                                    $current->Qty = $current->Qty - 1;
                                    $current->save();
                                }
                                break;
                            }
                        }
                    }
                }

                if (!($authPwd || $authPwdList)) {
                    throw new Exception(__('common.contents_wrongpassword'), "101");
                }
            }

            $cf = ContentFile::getQuery()
                ->where('ContentID', '=', $oContentID)
                ->where('StatusID', '=', eStatus::Active)
                ->orderBy('ContentFileID', 'DESC')
                ->first();
            if ($cf) {
                $oContentFileID = (int)$cf->ContentFileID;
                $oContentFilePath = $cf->FilePath;
                $oContentFileName = $cf->FileName;

                if ((int)$cf->Interactivity == Interactivity::ProcessQueued) {
                    if ((int)$cf->HasCreated == 1) {
                        $oContentFilePath = $cf->InteractiveFilePath;
                        $oContentFileName = $cf->InteractiveFileName;
                    } else {
                        throw new Exception(__('common.contents_interactive_file_hasnt_been_created'), "104");
                    }
                }
            } else {
                throw new Exception(__('common.list_norecord'), "102");
            }
        } else {
            throw new Exception(__('common.list_norecord'), "102");
        }
    }

    public static function download($RequestTypeID, $CustomerID, $ApplicationID, $ContentID, $ContentFileID, $ContentCoverImageFileID, $filepath, $filename)
    {
        $file = public_path($filepath . '/' . $filename);

        if (file_exists($file) && is_file($file)) {
            $fileSize = File::size($file);
            //throw new Exception($fileSize);

            $dataTransferred = 0;
            $percentage = 0;

            $r = new Requestt();
            $r->RequestTypeID = $RequestTypeID;
            $r->CustomerID = $CustomerID;
            $r->ApplicationID = $ApplicationID;
            $r->ContentID = $ContentID;
            $r->ContentFileID = $ContentFileID;
            if ($ContentCoverImageFileID > 0) {
                $r->ContentCoverImageFileID = $ContentCoverImageFileID;
            }
            $r->RequestDate = new DateTime();
            $r->IP = request()->ip(); //getenv("REMOTE_ADDR")
            $r->DeviceType = $_SERVER['HTTP_USER_AGENT']; //Holmes::get_device();
            $r->FileSize = $fileSize;
            $r->DataTransferred = 0;
            $r->Percentage = 0;
            $r->StatusID = eStatus::Active;
            $r->CreatorUserID = 0;
            $r->DateCreated = new DateTime();
            $r->ProcessUserID = 0;
            $r->ProcessDate = new DateTime();
            $r->ProcessTypeID = eProcessTypes::Insert;
            $r->save();

            $requestID = $r->RequestID;

            // set the download rate limit (=> 200,0 kb/s)
            $download_rate = 200.0;

            // send headers
            ob_end_clean();
            set_time_limit(0);
            header("Cache-Control: no-store, no-cache, must-revalidate");
            header("Cache-Control: post-check=0, pre-check=0", FALSE);
            header("Pragma: no-cache");
            header("Expires: " . GMDATE("D, d M Y H:i:s", MKTIME(DATE("H") + 2, DATE("i"), DATE("s"), DATE("m"), DATE("d"), DATE("Y"))) . " GMT");
            header("Last-Modified: " . GMDATE("D, d M Y H:i:s") . " GMT");
            header("Content-Type: application/octet-stream");
            header("Content-Length: " . $fileSize);
            header('Content-Disposition: inline; filename="' . str_replace(" ", "_", $filename) . '"'); //dosya isminde bosluk varsa problem oluyor!!!
            header("Content-Transfer-Encoding: binary\n");

            // open file stream
            $fc = fopen($file, "r");

            //http://psoug.org/snippet/Download_File_To_Client_53.htm
            //http://stackoverflow.com/questions/1507985/php-determine-how-many-bytes-sent-over-http
            //http://php.net/manual/en/function.ignore-user-abort.php
            //http://php.net/manual/en/function.http-send-file.php
            //http://stackoverflow.com/questions/737045/send-a-file-to-client
            //SELECT RequestID, FileSize, DataTransferred, Percentage FROM Request ORDER BY RequestID DESC LIMIT 10;
            //ignore_user_abort(true);

            while (!feof($fc) && connection_status() == 0) {

                //echo fread($fc, round($download_rate * 1024));
                print fread($fc, round($download_rate * 1024));

                // flush the content to the browser
                flush();

                //$dataTransferred = $dataTransferred + round($download_rate * 1024);
                //$dataTransferred = $dataTransferred + strlen($contents);
                $dataTransferred = ftell($fc);
                $percentage = ($dataTransferred * 100) / $fileSize;

                $r = Requestt::find($requestID);
                $r->DataTransferred = $dataTransferred;
                $r->Percentage = $percentage;
                $r->ProcessUserID = 0;
                $r->ProcessDate = new DateTime();
                $r->ProcessTypeID = eProcessTypes::Update;
                $r->save();
            }

            // close file stream
            fclose($fc);
        } else {
            throw new Exception(__('common.file_notfound'), "102");
        }
    }

    public static function downloadImage($ContentID, $RequestTypeID, $Width, $Height)
    {
        $content = DB::table('Customer AS c')
            ->join('Application AS a', function (JoinClause $join) {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->join('Content AS o', function (JoinClause $join) use ($ContentID) {
                $join->on('o.ContentID', '=', DB::raw($ContentID));
                $join->on('o.ApplicationID', '=', 'a.ApplicationID');
                $join->on('o.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->where('c.StatusID', '=', eStatus::Active)
            ->first(array('c.CustomerID', 'a.ApplicationID', 'o.ContentID', 'o.IsProtected'));
        if (!$content) {
            throw new Exception(__('common.list_norecord'), "102");
        }
        $contentFile = DB::table('ContentFile')
            ->where('ContentID', '=', $ContentID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentFileID', 'DESC')
            ->first();

        if (!$contentFile) {
            throw new Exception(__('common.list_norecord'), "102");
        }
        $contentCoverImageFile = DB::table('ContentCoverImageFile')
            ->where('ContentFileID', '=', $contentFile->ContentFileID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentCoverImageFileID', 'DESC')
            ->first();
        if (!$contentCoverImageFile) {
            throw new Exception(__('common.list_norecord'), "102");
        }

        if ($Width > 0 && $Height > 0) {
            //image var mi kontrol edip yok ise olusturup, ismini set edelim;
            $originalImage = public_path($contentCoverImageFile->FilePath . '/' . IMAGE_CROPPED_2048);
            if (!is_file($originalImage)) {
                $originalImage = public_path($contentCoverImageFile->FilePath . '/' . $contentCoverImageFile->SourceFileName);
            }
            $pathInfoOI = pathinfo($originalImage);
            $fileName = IMAGE_CROPPED_NAME . "_" . $Width . "x" . $Height . ".jpg";
            if (!is_file($pathInfoOI["dirname"] . "/" . $fileName)) {
                //resize original image to new path and then save it.
                if (!is_file($originalImage)) {
                    throw new Exception(__('common.file_notfound'), "102");
                }
                $im = new Imagick($originalImage);
                $im->resizeImage($Width, $Height, Imagick::FILTER_LANCZOS, 1);
                $im->writeImage($pathInfoOI["dirname"] . "/" . $fileName);
                $im->destroy();
            }
        } else {
            switch ($RequestTypeID) {
                case eRequestType::SMALL_IMAGE_FILE:
                    $fileName = $contentCoverImageFile->FileName2;
                    break;
                case eRequestType::NORMAL_IMAGE_FILE:
                    $fileName = $contentCoverImageFile->FileName2;
                    break;
                default:
                    throw new Exception('Not implemented', '102');
            }
        }

        $file = public_path($contentCoverImageFile->FilePath . '/' . $fileName);
        if (!is_file($file)) {
            throw new Exception(__('common.file_notfound'), "102");
        }
        $fileSize = File::size($file);
        $r = new Requestt();
        $r->RequestTypeID = $RequestTypeID;
        $r->CustomerID = (int)$content->CustomerID;
        $r->ApplicationID = (int)$content->ApplicationID;
        $r->ContentID = $ContentID;
        $r->ContentFileID = (int)$contentFile->ContentFileID;
        $r->ContentCoverImageFileID = $contentCoverImageFile->ContentCoverImageFileID;
        $r->RequestDate = new DateTime();
        $r->IP = request()->ip();
        $r->DeviceType = $_SERVER['HTTP_USER_AGENT']; //Holmes::get_device();
        $r->DeviceOS = Requestt::LINUX;
        $r->FileSize = $fileSize;
        $r->DataTransferred = 0;
        $r->Percentage = 0;
        $r->StatusID = eStatus::Active;
        $r->CreatorUserID = 0;
        $r->DateCreated = new DateTime();
        $r->ProcessUserID = 0;
        $r->ProcessDate = new DateTime();
        $r->ProcessTypeID = eProcessTypes::Insert;
        $r->save();

        $requestID = $r->RequestID;

        // set the download rate limit (=> 200,0 kb/s)
        $download_rate = 200.0;

        // send headers
        ob_end_clean();
        set_time_limit(0);
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", FALSE);
        header("Pragma: no-cache");
        header("Expires: " . GMDATE("D, d M Y H:i:s", MKTIME(DATE("H") + 2, DATE("i"), DATE("s"), DATE("m"), DATE("d"), DATE("Y"))) . " GMT");
        header("Last-Modified: " . GMDATE("D, d M Y H:i:s") . " GMT");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . $fileSize);
        header('Content-Disposition: inline; filename="' . str_replace(" ", "_", $fileName) . '"'); //dosya isminde bosluk varsa problem oluyor!!!
        header("Content-Transfer-Encoding: binary\n");
        // open file stream
        $fc = fopen($file, "r");
        while (!feof($fc) && connection_status() == 0) {
            //echo fread($fc, round($download_rate * 1024));
            print fread($fc, round($download_rate * 1024));

            // flush the content to the browser
            flush();
            $dataTransferred = ftell($fc);
            $percentage = ($dataTransferred * 100) / $fileSize;

            $r = Requestt::find($requestID);
            $r->DataTransferred = $dataTransferred;
            $r->Percentage = $percentage;
            $r->ProcessUserID = 0;
            $r->ProcessDate = new DateTime();
            $r->ProcessTypeID = eProcessTypes::Update;
            $r->save();
        }
        fclose($fc);
    }

    /**
     * Sends Error Email to custom.admin_email_set and Logs it
     * @param string $msg
     */
    public static function sendErrorMail($msg)
    {
        $toEmailSet = Config::get('custom.admin_email_set');
        $subject = __('common.task_subject');
        Log::info($msg);
        Bundle::start('messages');
        foreach ($toEmailSet as $toEmail) {
            Message::send(function ($m) use ($toEmail, $subject, $msg) {
                $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
                $m->to($toEmail);
                $m->subject($subject);
                $m->body($msg);
            });
        }
    }

    public static function sendPaymentUserReminderMail($userList)
    {
        return; //573573
        Bundle::start('messages');
        foreach ($userList as $user) {
            if (!in_array($user["warning_mail_phase"], array(1, 2, 3))) {
                continue;
            }

            Message::send(function ($m) use ($user) {
                $msg = "";
                switch ($user["warning_mail_phase"]) {
                    case 1:
                        $msg = "Değerli Müşterimiz, \r\n\r\n"
                            . "Bekleyen bir ödemeniz bulunmaktadır ve iki hafta içinde ödemenizi tamamlamanız gerekmektedir. "
                            . "İlginiz için teşekkür eder, sizinle çalışmaktan mutluluk duymaktayız. \r\n\r\n"
                            . "Eğer ödemenizi gerçekleştirdiyseniz bu maili dikkate almayabilirsiniz. \r\n\r\n"
                            . "İyi çalışmalar.";
                        break;
                    case 2:
                        $msg = "Değerli Müşterimiz, \r\n\r\n"
                            . "Borcunuzun son ödeme tarihi 7 gün sonradır, en kısa zamanda ödemenizi gerçekleştirmeniz gerekmektedir. "
                            . "İlginiz için teşekkür eder, sizinle çalışmaktan mutluluk duymaktayız. \r\n\r\n"
                            . "Eğer ödemenizi gerçekleştirdiyseniz bu maili dikkate almayabilirsiniz. \r\n\r\n"
                            . "İyi çalışmalar.";
                        break;
                    case 3:
                        $msg = "Değerli Müşterimiz, \r\n\r\n"
                            . "Borcunuzu 3 gün içinde ödemediğiniz takdirde uygulamanız bloke edilecektir. \r\n\r\n"
                            . "Eğer ödemenizi gerçekleştirdiyseniz bu maili dikkate almayabilirsiniz. \r\n\r\n"
                            . "İyi çalışmalar.";
                        break;
                }

                $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
                $m->to($user["email"]);
                $m->subject("Gale Press Dijital Yayin Platformu Ödeme Hatırlatma Maili");
                $m->body($msg);
            });
        }
    }

    public static function sendPaymentAdminReminderMail($msg)
    {
        $adminMailSet = Config::get("custom.payment_delay_reminder_admin_mail_set");
        Bundle::start('messages');
        foreach ($adminMailSet as $adminMail) {
            Message::send(function ($m) use ($adminMail, $msg) {
                $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
                $m->to($adminMail);
                $m->subject("Gale Press Ödeme Hatırlatma Maili");
                $m->body($msg);
            });
        }
    }

    public static function sendStatusMail($msg)
    {
        $toEmailSet = Config::get('custom.admin_email_set');
        $subject = __('common.task_status');
        Log::info($msg);
        Bundle::start('messages');
        foreach ($toEmailSet as $toEmail) {
            Message::send(function ($m) use ($toEmail, $subject, $msg) {
                $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
                $m->to($toEmail);
                $m->subject($subject);
                $m->body($msg);
            });
        }
    }

    public static function sendEmail($toEmail, $toDisplayName, $subject, $msg)
    {
        try {
            Bundle::start('messages');
            Message::send(function ($m) use ($toEmail, $toDisplayName, $subject, $msg) {
                $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
                //$m->to($toEmail);
                $m->to($toEmail, $toDisplayName);
                $m->subject($subject);
                $m->body($msg);
                //$m->html(true);
            });
        } catch (Exception $e) {
            //return 'Mailer error: ' . $e->getMessage();
        }
    }

    public static function sendHtmlEmail($toEmail, $toDisplayName, $subject, $msg)
    {
        try {
            Bundle::start('messages');
            Message::send(function ($m) use ($toEmail, $toDisplayName, $subject, $msg) {
                $m->from((string)__('maillang.contanct_email'), Config::get('custom.mail_displayname'));
                //$m->to($toEmail);
                $m->to($toEmail, $toDisplayName);
                $m->subject($subject);
                $m->body($msg);
                $m->html(true);
            });
            return true;
        } catch (Exception $e) {
            // return 'Mailer error: ' . $e->getMessage();
            return false;
        }
    }

    public static function generatePassword($length = 6, $level = 2)
    {
        list($usec, $sec) = explode(' ', microtime());
        srand((float)$sec + ((float)$usec * 100000));

        $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
        $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

        $password = "";
        $counter = 0;

        while ($counter < $length) {
            $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level]) - 1), 1);

            // All character must be different
            if (!strstr($password, $actChar)) {
                $password .= $actChar;
                $counter++;
            }
        }
        return $password;
    }

    public static function dateLocalize($format, $timestamp = 'time()')
    {
        return date($format, $timestamp);
    }

    public static function dateWrite($date, $useLocal = true)
    {
        if (empty($date)) {
            $date = date("Y-m-d");
        }
        $ret = date('Y-m-d H:i:s', strtotime($date));
        if ($useLocal) {
            $ret = Common::convert2Localzone($ret, true);
        }
        return $ret;
    }

    public static function convert2Localzone($d, $write = false)
    {
        //2009-07-14 04:27:16
        if (Auth::check()) {
            $sign = '+';
            $hour = 0;
            $minute = 0;

            $timezone = Auth::user()->Timezone;
            $timezone = str_replace('UTC', '', $timezone);
            $timezone = preg_replace('/\s+/', '', $timezone);
            //var_dump($timezone);

            if (Str::length($timezone) > 0) {

                $sign = substr($timezone, 0, 1);
                $timezone = str_replace($sign, '', $timezone);
                $pos = strrpos($timezone, ":");
                if ($pos === false) {
                    //yok
                    $hour = (int)$timezone;
                } else {
                    //var
                    $segment = explode(":", $timezone);
                    $hour = (int)$segment[0];
                    $minute = (int)$segment[1];
                }
            }

            //var_dump($sign);
            //var_dump($hour);
            //var_dump($minute);
            //var_dump($d);

            if ($write) {
                if ($sign == '+') {
                    $sign = '-';
                } else {
                    $sign = '+';
                }
            }

            if ($hour > 0) {
                $date = new DateTime($d);
                $d = date("Y-m-d H:i:s", strtotime($sign . $hour . ' hours', $date->getTimestamp()));
            }

            if ($minute > 0) {
                $date = new DateTime($d);
                $d = date("Y-m-d H:i:s", strtotime($sign . $minute . ' minutes', $date->getTimestamp()));
            }
            //var_dump($d);
        }
        return $d;
    }

    public static function getFormattedData($data, $type)
    {
        $ret = "";
        //$FieldTypeVariant
        //Number
        //String
        //Percent
        //DateTime
        //Date
        //Bit
        if ($type == "Number") {
            $ret = $data;
        } elseif ($type == "String") {
            if (Common::startsWith($data, '!!!')) {
                $ret = __('common.' . str_replace('!!!', '', $data))->get();
            } else {
                $ret = $data;
            }
        } elseif ($type == "Percent") {
            $ret = '% ' . round((float)$data, 2);
        } elseif ($type == "DateTime") {
            $ret = Common::dateRead($data, "dd.MM.yyyy HH:mm");
        } elseif ($type == "Date") {
            $ret = Common::dateRead($data, "dd.MM.yyyy");
        } elseif ($type == "Bit") {
            $ret = ((int)$data == 1 ? "Evet" : "Hayır");
        } elseif ($type == "Size") {

            $size = (float)$data;
            $s = "Byte";

            if ($size > 1024) {

                $size = $size / 1024;
                $s = "KB";

                if ($size > 1024) {

                    $size = $size / 1024;
                    $s = "MB";

                    if ($size > 1024) {

                        $size = $size / 1024;
                        $s = "GB";

                        if ($size > 1024) {

                            $size = $size / 1024;
                            $s = "TB";
                        }
                    }
                }
            }
            $size = number_format($size, 2, '.', '');
            $ret = $size . " " . $s;
        } else {
            $ret = $data;
        }
        return $ret;
    }

    public static function startsWith($haystack, $needle)
    {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }

    public static function dateRead($date, $format, $useLocal = true)
    {
        if (empty($date)) {
            $date = date("Y-m-d");
        }
        $ret = "";
        if ($useLocal) {
            $date = Common::convert2Localzone($date);
        }

        if (App::isLocale('usa')) {
            if ($format == 'd.m.Y') {
                $format = 'm/d/Y';
            } else if ($format == 'd.m.Y H:i') {
                $format = 'm/d/Y H:i';
            } else if ($format == 'd.m.Y H:i:s') {
                $format = 'm/d/Y H:i:s';
            }
        }
        return date($format, strtotime($date));
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            //return true;
            return false;
        }
        return (substr($haystack, -$length) === $needle);
    }

    public static function monthName($month)
    {
        $m = __('common.month_names');
        return $m[$month];
    }

    public static function getLocationData($type, $customerID, $applicationID, $contentID, $country = '', $city = '')
    {
        $currentUser = Auth::user();

        $isCountry = false;
        $isCity = false;
        $isDistrict = false;
        $column = 'Country';

        if ($type == 'country') {
            $isCountry = true;
            $column = 'Country';
        } elseif ($type == 'city') {
            $isCity = true;
            $column = 'City';
        } elseif ($type == 'district') {
            $isDistrict = true;
            $column = 'District';
        }

        $rs = DB::table('Statistic')
            ->where(function ($query) use ($currentUser, $isCountry, $isCity, $isDistrict, $customerID, $applicationID, $contentID, $country, $city) {
                if ((int)$currentUser->UserTypeID == eUserTypes::Manager && $customerID > 0) {
                    $query->where('CustomerID', '=', $customerID);
                } elseif ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
                    $query->where('CustomerID', '=', $currentUser->CustomerID);
                }

                if ($applicationID > 0) {
                    if (Common::CheckApplicationOwnership($applicationID)) {
                        $query->where('ApplicationID', '=', $applicationID);
                    }
                }

                if ($contentID > 0) {
                    if (Common::CheckContentOwnership($contentID)) {
                        $query->where('ContentID', '=', $contentID);
                    }
                }

                if ($isCity) {
                    $query->where('Country', '=', (strlen($country) > 0 ? $country : '???'));
                } elseif ($isDistrict) {
                    $query->where('Country', '=', (strlen($country) > 0 ? $country : '???'));
                    $query->where('City', '=', (strlen($city) > 0 ? $city : '???'));
                }
            })
            ->distinct()
            ->orderBy($column, 'ASC')
            ->get($column);

        return $rs;
    }

    public static function CheckContentOwnership($contentID)
    {
        $currentUser = Auth::user();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer) {
            $content = Content::find($contentID);
            if ($content) {
                if ((int)$content->StatusID == eStatus::Active) {
                    if ((int)$content->Application->StatusID == eStatus::Active) {
                        $c = $content->Application->Customer;
                        if ((int)$c->StatusID == eStatus::Active) {
                            if ((int)$currentUser->CustomerID == (int)$c->CustomerID) {
                                return true;
                            }
                        }
                    }
                }
            }
            return false;
        } else {
            return true;
        }
    }

    public static function toExcel($twoDimensionalArray, $toFile)
    {
        $rows = array();
        $sep = "\t";
        foreach ($twoDimensionalArray as $row) {
            $tmpStr = "";
            foreach ($row as $cell) {
                $r = "";
                if ($cell != "") {
                    $r .= "$cell" . $sep;
                } else {
                    $r .= "" . $sep;
                }
                $tmpStr .= $r;
            }

            $tmpStr1 = str_replace($sep . "$", "", $tmpStr);
            $tmpStr2 = preg_replace("/\r\n|\n\r|\n|\r/", " ", $tmpStr1);
            $tmpStr2 .= "\t";
            $tmpStr3 = trim($tmpStr2);
            $tmpStr3 .= "\n";

            $rows[] = $tmpStr3;
        }

        $rows[] = "\n";
        $result = implode("", $rows);
        $finalResult = chr(255) . chr(254) . iconv("UTF-8", "UTF-16LE//IGNORE", $result);
        $fileHandle = fopen($toFile, "w");
        fwrite($fileHandle, $finalResult);
        fclose($fileHandle);
    }

    public static function getPostDataString($postData)
    {
        $postDataString = "";
        foreach ($postData as $key => $value) {
            if (empty($postDataString)) {
                $postDataString .= $key . "=" . $value;
            } else {
                $postDataString .= '&' . $key . "=" . $value;
            }
        }
        return $postDataString;
    }

    public static function localize($key, $replacements = array(), $language = null)
    {
        $action = app('request')->route()->getAction();

        $result = trans(class_basename($action['controller']) . '.' . $key, $replacements, 'messages', $language);
        if (empty($result)) {
            $result = $key;
        }
        return $result;
    }

    public static function moneyFormat($inputName)
    {
        $input = request($inputName);
        return str_replace(",", ".", str_replace(".", "", $input));
    }

    public static function metaContentLanguage()
    {
        switch (Config::get('application.language')) {
            case 'tr':
                return 'tr';
            case 'en':
            case 'usa':
                return 'en';
            case 'de':
                return 'de';
            default:
                return 'en';
        }
    }

    /**
     * @param Exception $exception
     * @return string
     */
    public static function getExceptionTraceAsString($exception)
    {
        $rtn = "";
        $count = 0;
        foreach ($exception->getTrace() as $frame) {
            $args = "";
            if (isset($frame['args'])) {
                $args = array();
                foreach ($frame['args'] as $arg) {
                    if (is_string($arg)) {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg)) {
                        $args[] = "Array";
                    } elseif (is_null($arg)) {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg)) {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg)) {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg)) {
                        $args[] = get_resource_type($arg);
                    } else {
                        $args[] = $arg;
                    }
                }
                $args = join(", ", $args);
            }
            $file = isset($frame['file']) ? $frame['file'] : '';
            $line = isset($frame['line']) ? $frame['line'] : '';
            $function = isset($frame['function']) ? $frame['function'] : '';
            $rtn .= sprintf("#%s %s(%s): %s(%s)\n",
                $count,
                "File: " . $file,
                "Line: " . $line,
                "Function: " . $function,
                $args);
            $count++;
        }
        return $rtn;
    }

    public static function Cast(&$destination, stdClass $source)
    {
        $sourceReflection = new \ReflectionObject($source);
        $sourceProperties = $sourceReflection->getProperties();
        foreach ($sourceProperties as $sourceProperty) {
            $name = $sourceProperty->getName();
            if (gettype($destination->{$name}) == "object") {
                self::Cast($destination->{$name}, $source->$name);
            } else {
                $destination->{$name} = $source->$name;
            }
        }
    }

    public static function getLocaleId()
    {
        $langs = Config::get('app.langs');
        return $langs[App::getLocale()];
    }

    public static function getClass($row) {
        if(isset($row->IsMaster) && $row->IsMaster == 1) {
            return ' class="masterContentRow"';
        }
        return '';
    }
}


function localDateFormat($format = 'dd.MM.yyyy') {
    $currentLang = app()->getLocale();
    if($currentLang != 'usa') {
        return $format;
    } else {
        if($format == 'dd.MM.yyyy') {
            return 'mm/dd/yyyy';
        }
    }

}

/*
 * jQuery File Upload Plugin PHP Class
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * https://opensource.org/licenses/MIT
 */
class UploadHandler
{
    protected $options;
    // PHP File Upload error message codes:
    // http://php.net/manual/en/features.file-upload.errors.php
    protected $error_messages = array(
        1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
        2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
        3 => 'The uploaded file was only partially uploaded',
        4 => 'No file was uploaded',
        6 => 'Missing a temporary folder',
        7 => 'Failed to write file to disk',
        8 => 'A PHP extension stopped the file upload',
        'post_max_size' => 'The uploaded file exceeds the post_max_size directive in php.ini',
        'max_file_size' => 'File is too big',
        'min_file_size' => 'File is too small',
        'accept_file_types' => 'Filetype not allowed',
        'max_number_of_files' => 'Maximum number of files exceeded',
        'max_width' => 'Image exceeds maximum width',
        'min_width' => 'Image requires a minimum width',
        'max_height' => 'Image exceeds maximum height',
        'min_height' => 'Image requires a minimum height',
        'abort' => 'File upload aborted',
        'image_resize' => 'Failed to resize image'
    );
    protected $image_objects = array();
    public function __construct($options = null, $initialize = true, $error_messages = null) {
        $this->response = array();
        $this->options = array(
            'script_url' => $this->get_full_url().'/'.$this->basename($this->get_server_var('SCRIPT_NAME')),
            'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/files/',
            'upload_url' => $this->get_full_url().'/files/',
            'input_stream' => 'php://input',
            'user_dirs' => false,
            'mkdir_mode' => 0755,
            'param_name' => 'files',
            // Set the following option to 'POST', if your server does not support
            // DELETE requests. This is a parameter sent to the client:
            'delete_type' => 'DELETE',
            'access_control_allow_origin' => '*',
            'access_control_allow_credentials' => false,
            'access_control_allow_methods' => array(
                'OPTIONS',
                'HEAD',
                'GET',
                'POST',
                'PUT',
                'PATCH',
                'DELETE'
            ),
            'access_control_allow_headers' => array(
                'Content-Type',
                'Content-Range',
                'Content-Disposition'
            ),
            // By default, allow redirects to the referer protocol+host:
            'redirect_allow_target' => '/^'.preg_quote(
                    parse_url($this->get_server_var('HTTP_REFERER'), PHP_URL_SCHEME)
                    .'://'
                    .parse_url($this->get_server_var('HTTP_REFERER'), PHP_URL_HOST)
                    .'/', // Trailing slash to not match subdomains by mistake
                    '/' // preg_quote delimiter param
                ).'/',
            // Enable to provide file downloads via GET requests to the PHP script:
            //     1. Set to 1 to download files via readfile method through PHP
            //     2. Set to 2 to send a X-Sendfile header for lighttpd/Apache
            //     3. Set to 3 to send a X-Accel-Redirect header for nginx
            // If set to 2 or 3, adjust the upload_url option to the base path of
            // the redirect parameter, e.g. '/files/'.
            'download_via_php' => false,
            // Read files in chunks to avoid memory limits when download_via_php
            // is enabled, set to 0 to disable chunked reading of files:
            'readfile_chunk_size' => 10 * 1024 * 1024, // 10 MiB
            // Defines which files can be displayed inline when downloaded:
            'inline_file_types' => '/\.(gif|jpe?g|png)$/i',
            // Defines which files (based on their names) are accepted for upload:
            'accept_file_types' => '/.+$/i',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            // The maximum number of files for the upload directory:
            'max_number_of_files' => null,
            // Defines which files are handled as image files:
            'image_file_types' => '/\.(gif|jpe?g|png)$/i',
            // Use exif_imagetype on all files to correct file extensions:
            'correct_image_extensions' => false,
            // Image resolution restrictions:
            'max_width' => null,
            'max_height' => null,
            'min_width' => 1,
            'min_height' => 1,
            // Set the following option to false to enable resumable uploads:
            'discard_aborted_uploads' => true,
            // Set to 0 to use the GD library to scale and orient images,
            // set to 1 to use imagick (if installed, falls back to GD),
            // set to 2 to use the ImageMagick convert binary directly:
            'image_library' => 1,
            // Uncomment the following to define an array of resource limits
            // for imagick:
            /*
            'imagick_resource_limits' => array(
                imagick::RESOURCETYPE_MAP => 32,
                imagick::RESOURCETYPE_MEMORY => 32
            ),
            */
            // Command or path for to the ImageMagick convert binary:
            'convert_bin' => 'convert',
            // Uncomment the following to add parameters in front of each
            // ImageMagick convert call (the limit constraints seem only
            // to have an effect if put in front):
            /*
            'convert_params' => '-limit memory 32MiB -limit map 32MiB',
            */
            // Command or path for to the ImageMagick identify binary:
            'identify_bin' => 'identify',
            'image_versions' => array(
                // The empty image version key defines options for the original image:
                '' => array(
                    // Automatically rotate images based on EXIF meta data:
                    'auto_orient' => true
                ),
                // Uncomment the following to create medium sized images:
                /*
                'medium' => array(
                    'max_width' => 800,
                    'max_height' => 600
                ),
                */
                'thumbnail' => array(
                    // Uncomment the following to use a defined directory for the thumbnails
                    // instead of a subdirectory based on the version identifier.
                    // Make sure that this directory doesn't allow execution of files if you
                    // don't pose any restrictions on the type of uploaded files, e.g. by
                    // copying the .htaccess file from the files directory for Apache:
                    //'upload_dir' => dirname($this->get_server_var('SCRIPT_FILENAME')).'/thumb/',
                    //'upload_url' => $this->get_full_url().'/thumb/',
                    // Uncomment the following to force the max
                    // dimensions and e.g. create square thumbnails:
                    //'crop' => true,
                    'max_width' => 80,
                    'max_height' => 80
                )
            ),
            'print_response' => true
        );
        if ($options) {
            $this->options = $options + $this->options;
        }
        if ($error_messages) {
            $this->error_messages = $error_messages + $this->error_messages;
        }
        if ($initialize) {
            $this->initialize();
        }
    }
    protected function initialize() {
        switch ($this->get_server_var('REQUEST_METHOD')) {
            case 'OPTIONS':
            case 'HEAD':
                $this->head();
                break;
            case 'GET':
                $this->get($this->options['print_response']);
                break;
            case 'PATCH':
            case 'PUT':
            case 'POST':
                $this->post($this->options['print_response']);
                break;
            case 'DELETE':
                $this->delete($this->options['print_response']);
                break;
            default:
                $this->header('HTTP/1.1 405 Method Not Allowed');
        }
    }
    protected function get_full_url() {
        $https = !empty($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'], 'on') === 0 ||
            !empty($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
            strcasecmp($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') === 0;
        return
            ($https ? 'https://' : 'http://').
            (!empty($_SERVER['REMOTE_USER']) ? $_SERVER['REMOTE_USER'].'@' : '').
            (isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : ($_SERVER['SERVER_NAME'].
                ($https && $_SERVER['SERVER_PORT'] === 443 ||
                $_SERVER['SERVER_PORT'] === 80 ? '' : ':'.$_SERVER['SERVER_PORT']))).
            substr($_SERVER['SCRIPT_NAME'],0, strrpos($_SERVER['SCRIPT_NAME'], '/'));
    }
    protected function get_user_id() {
        @session_start();
        return session_id();
    }
    protected function get_user_path() {
        if ($this->options['user_dirs']) {
            return $this->get_user_id().'/';
        }
        return '';
    }
    protected function get_upload_path($file_name = null, $version = null) {
        $file_name = $file_name ? $file_name : '';
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_dir = @$this->options['image_versions'][$version]['upload_dir'];
            if ($version_dir) {
                return $version_dir.$this->get_user_path().$file_name;
            }
            $version_path = $version.'/';
        }
        return $this->options['upload_dir'].$this->get_user_path()
            .$version_path.$file_name;
    }
    protected function get_query_separator($url) {
        return strpos($url, '?') === false ? '?' : '&';
    }
    protected function get_download_url($file_name, $version = null, $direct = false) {
        if (!$direct && $this->options['download_via_php']) {
            $url = $this->options['script_url']
                .$this->get_query_separator($this->options['script_url'])
                .$this->get_singular_param_name()
                .'='.rawurlencode($file_name);
            if ($version) {
                $url .= '&version='.rawurlencode($version);
            }
            return $url.'&download=1';
        }
        if (empty($version)) {
            $version_path = '';
        } else {
            $version_url = @$this->options['image_versions'][$version]['upload_url'];
            if ($version_url) {
                return $version_url.$this->get_user_path().rawurlencode($file_name);
            }
            $version_path = rawurlencode($version).'/';
        }
        return $this->options['upload_url'].$this->get_user_path()
            .$version_path.rawurlencode($file_name);
    }
    protected function set_additional_file_properties($file) {
        $file->deleteUrl = $this->options['script_url']
            .$this->get_query_separator($this->options['script_url'])
            .$this->get_singular_param_name()
            .'='.rawurlencode($file->name);
        $file->deleteType = $this->options['delete_type'];
        if ($file->deleteType !== 'DELETE') {
            $file->deleteUrl .= '&_method=DELETE';
        }
        if ($this->options['access_control_allow_credentials']) {
            $file->deleteWithCredentials = true;
        }
    }
    // Fix for overflowing signed 32 bit integers,
    // works for sizes up to 2^32-1 bytes (4 GiB - 1):
    protected function fix_integer_overflow($size) {
        if ($size < 0) {
            $size += 2.0 * (PHP_INT_MAX + 1);
        }
        return $size;
    }
    protected function get_file_size($file_path, $clear_stat_cache = false) {
        if ($clear_stat_cache) {
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                clearstatcache(true, $file_path);
            } else {
                clearstatcache();
            }
        }
        return $this->fix_integer_overflow(filesize($file_path));
    }
    protected function is_valid_file_object($file_name) {
        $file_path = $this->get_upload_path($file_name);
        if (is_file($file_path) && $file_name[0] !== '.') {
            return true;
        }
        return false;
    }
    protected function get_file_object($file_name) {
        if ($this->is_valid_file_object($file_name)) {
            $file = new \stdClass();
            $file->name = $file_name;
            $file->size = $this->get_file_size(
                $this->get_upload_path($file_name)
            );
            $file->url = $this->get_download_url($file->name);
            foreach ($this->options['image_versions'] as $version => $options) {
                if (!empty($version)) {
                    if (is_file($this->get_upload_path($file_name, $version))) {
                        $file->{$version.'Url'} = $this->get_download_url(
                            $file->name,
                            $version
                        );
                    }
                }
            }
            $this->set_additional_file_properties($file);
            return $file;
        }
        return null;
    }
    protected function get_file_objects($iteration_method = 'get_file_object') {
        $upload_dir = $this->get_upload_path();
        if (!is_dir($upload_dir)) {
            return array();
        }
        return array_values(array_filter(array_map(
            array($this, $iteration_method),
            scandir($upload_dir)
        )));
    }
    protected function count_file_objects() {
        return count($this->get_file_objects('is_valid_file_object'));
    }
    protected function get_error_message($error) {
        return isset($this->error_messages[$error]) ?
            $this->error_messages[$error] : $error;
    }
    public function get_config_bytes($val) {
        $val = trim($val);
        $last = strtolower($val[strlen($val)-1]);
        $val = (int)$val;
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $this->fix_integer_overflow($val);
    }
    protected function validate($uploaded_file, $file, $error, $index) {
        if ($error) {
            $file->error = $this->get_error_message($error);
            return false;
        }
        $content_length = $this->fix_integer_overflow(
            (int)$this->get_server_var('CONTENT_LENGTH')
        );
        $post_max_size = $this->get_config_bytes(ini_get('post_max_size'));
        if ($post_max_size && ($content_length > $post_max_size)) {
            $file->error = $this->get_error_message('post_max_size');
            return false;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            $file->error = $this->get_error_message('accept_file_types');
            return false;
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = $this->get_file_size($uploaded_file);
        } else {
            $file_size = $content_length;
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
        ) {
            $file->error = $this->get_error_message('max_file_size');
            return false;
        }
        if ($this->options['min_file_size'] &&
            $file_size < $this->options['min_file_size']) {
            $file->error = $this->get_error_message('min_file_size');
            return false;
        }
        if (is_int($this->options['max_number_of_files']) &&
            ($this->count_file_objects() >= $this->options['max_number_of_files']) &&
            // Ignore additional chunks of existing files:
            !is_file($this->get_upload_path($file->name))) {
            $file->error = $this->get_error_message('max_number_of_files');
            return false;
        }
        $max_width = @$this->options['max_width'];
        $max_height = @$this->options['max_height'];
        $min_width = @$this->options['min_width'];
        $min_height = @$this->options['min_height'];
        if (($max_width || $max_height || $min_width || $min_height)
            && preg_match($this->options['image_file_types'], $file->name)) {
            list($img_width, $img_height) = $this->get_image_size($uploaded_file);
            // If we are auto rotating the image by default, do the checks on
            // the correct orientation
            if (
                @$this->options['image_versions']['']['auto_orient'] &&
                function_exists('exif_read_data') &&
                ($exif = @exif_read_data($uploaded_file)) &&
                (((int) @$exif['Orientation']) >= 5)
            ) {
                $tmp = $img_width;
                $img_width = $img_height;
                $img_height = $tmp;
                unset($tmp);
            }
        }
        if (!empty($img_width)) {
            if ($max_width && $img_width > $max_width) {
                $file->error = $this->get_error_message('max_width');
                return false;
            }
            if ($max_height && $img_height > $max_height) {
                $file->error = $this->get_error_message('max_height');
                return false;
            }
            if ($min_width && $img_width < $min_width) {
                $file->error = $this->get_error_message('min_width');
                return false;
            }
            if ($min_height && $img_height < $min_height) {
                $file->error = $this->get_error_message('min_height');
                return false;
            }
        }
        return true;
    }
    protected function upcount_name_callback($matches) {
        $index = isset($matches[1]) ? ((int)$matches[1]) + 1 : 1;
        $ext = isset($matches[2]) ? $matches[2] : '';
        return ' ('.$index.')'.$ext;
    }
    protected function upcount_name($name) {
        return preg_replace_callback(
            '/(?:(?: \(([\d]+)\))?(\.[^.]+))?$/',
            array($this, 'upcount_name_callback'),
            $name,
            1
        );
    }
    protected function get_unique_filename($file_path, $name, $size, $type, $error,
                                           $index, $content_range) {
        while(is_dir($this->get_upload_path($name))) {
            $name = $this->upcount_name($name);
        }
        // Keep an existing filename if this is part of a chunked upload:
        $uploaded_bytes = $this->fix_integer_overflow((int)$content_range[1]);
        while (is_file($this->get_upload_path($name))) {
            if ($uploaded_bytes === $this->get_file_size(
                    $this->get_upload_path($name))) {
                break;
            }
            $name = $this->upcount_name($name);
        }
        return $name;
    }
    protected function fix_file_extension($file_path, $name, $size, $type, $error,
                                          $index, $content_range) {
        // Add missing file extension for known image types:
        if (strpos($name, '.') === false &&
            preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $name .= '.'.$matches[1];
        }
        if ($this->options['correct_image_extensions'] &&
            function_exists('exif_imagetype')) {
            switch (@exif_imagetype($file_path)){
                case IMAGETYPE_JPEG:
                    $extensions = array('jpg', 'jpeg');
                    break;
                case IMAGETYPE_PNG:
                    $extensions = array('png');
                    break;
                case IMAGETYPE_GIF:
                    $extensions = array('gif');
                    break;
            }
            // Adjust incorrect image file extensions:
            if (!empty($extensions)) {
                $parts = explode('.', $name);
                $extIndex = count($parts) - 1;
                $ext = strtolower(@$parts[$extIndex]);
                if (!in_array($ext, $extensions)) {
                    $parts[$extIndex] = $extensions[0];
                    $name = implode('.', $parts);
                }
            }
        }
        return $name;
    }
    protected function trim_file_name($file_path, $name, $size, $type, $error,
                                      $index, $content_range) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $name = trim($this->basename(stripslashes($name)), ".\x00..\x20");
        // Use a timestamp for empty filenames:
        if (!$name) {
            $name = str_replace('.', '-', microtime(true));
        }
        return $name;
    }
    protected function get_file_name($file_path, $name, $size, $type, $error,
                                     $index, $content_range) {
        $name = $this->trim_file_name($file_path, $name, $size, $type, $error,
            $index, $content_range);
        return $this->get_unique_filename(
            $file_path,
            $this->fix_file_extension($file_path, $name, $size, $type, $error,
                $index, $content_range),
            $size,
            $type,
            $error,
            $index,
            $content_range
        );
    }
    protected function get_scaled_image_file_paths($file_name, $version) {
        $file_path = $this->get_upload_path($file_name);
        if (!empty($version)) {
            $version_dir = $this->get_upload_path(null, $version);
            if (!is_dir($version_dir)) {
                mkdir($version_dir, $this->options['mkdir_mode'], true);
            }
            $new_file_path = $version_dir.'/'.$file_name;
        } else {
            $new_file_path = $file_path;
        }
        return array($file_path, $new_file_path);
    }
    protected function gd_get_image_object($file_path, $func, $no_cache = false) {
        if (empty($this->image_objects[$file_path]) || $no_cache) {
            $this->gd_destroy_image_object($file_path);
            $this->image_objects[$file_path] = $func($file_path);
        }
        return $this->image_objects[$file_path];
    }
    protected function gd_set_image_object($file_path, $image) {
        $this->gd_destroy_image_object($file_path);
        $this->image_objects[$file_path] = $image;
    }
    protected function gd_destroy_image_object($file_path) {
        $image = (isset($this->image_objects[$file_path])) ? $this->image_objects[$file_path] : null ;
        return $image && imagedestroy($image);
    }
    protected function gd_imageflip($image, $mode) {
        if (function_exists('imageflip')) {
            return imageflip($image, $mode);
        }
        $new_width = $src_width = imagesx($image);
        $new_height = $src_height = imagesy($image);
        $new_img = imagecreatetruecolor($new_width, $new_height);
        $src_x = 0;
        $src_y = 0;
        switch ($mode) {
            case '1': // flip on the horizontal axis
                $src_y = $new_height - 1;
                $src_height = -$new_height;
                break;
            case '2': // flip on the vertical axis
                $src_x  = $new_width - 1;
                $src_width = -$new_width;
                break;
            case '3': // flip on both axes
                $src_y = $new_height - 1;
                $src_height = -$new_height;
                $src_x  = $new_width - 1;
                $src_width = -$new_width;
                break;
            default:
                return $image;
        }
        imagecopyresampled(
            $new_img,
            $image,
            0,
            0,
            $src_x,
            $src_y,
            $new_width,
            $new_height,
            $src_width,
            $src_height
        );
        return $new_img;
    }
    protected function gd_orient_image($file_path, $src_img) {
        if (!function_exists('exif_read_data')) {
            return false;
        }
        $exif = @exif_read_data($file_path);
        if ($exif === false) {
            return false;
        }
        $orientation = (int)@$exif['Orientation'];
        if ($orientation < 2 || $orientation > 8) {
            return false;
        }
        switch ($orientation) {
            case 2:
                $new_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_VERTICAL') ? IMG_FLIP_VERTICAL : 2
                );
                break;
            case 3:
                $new_img = imagerotate($src_img, 180, 0);
                break;
            case 4:
                $new_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_HORIZONTAL') ? IMG_FLIP_HORIZONTAL : 1
                );
                break;
            case 5:
                $tmp_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_HORIZONTAL') ? IMG_FLIP_HORIZONTAL : 1
                );
                $new_img = imagerotate($tmp_img, 270, 0);
                imagedestroy($tmp_img);
                break;
            case 6:
                $new_img = imagerotate($src_img, 270, 0);
                break;
            case 7:
                $tmp_img = $this->gd_imageflip(
                    $src_img,
                    defined('IMG_FLIP_VERTICAL') ? IMG_FLIP_VERTICAL : 2
                );
                $new_img = imagerotate($tmp_img, 270, 0);
                imagedestroy($tmp_img);
                break;
            case 8:
                $new_img = imagerotate($src_img, 90, 0);
                break;
            default:
                return false;
        }
        $this->gd_set_image_object($file_path, $new_img);
        return true;
    }
    protected function gd_create_scaled_image($file_name, $version, $options) {
        if (!function_exists('imagecreatetruecolor')) {
            error_log('Function not found: imagecreatetruecolor');
            return false;
        }
        list($file_path, $new_file_path) =
            $this->get_scaled_image_file_paths($file_name, $version);
        $type = strtolower(substr(strrchr($file_name, '.'), 1));
        switch ($type) {
            case 'jpg':
            case 'jpeg':
                $src_func = 'imagecreatefromjpeg';
                $write_func = 'imagejpeg';
                $image_quality = isset($options['jpeg_quality']) ?
                    $options['jpeg_quality'] : 75;
                break;
            case 'gif':
                $src_func = 'imagecreatefromgif';
                $write_func = 'imagegif';
                $image_quality = null;
                break;
            case 'png':
                $src_func = 'imagecreatefrompng';
                $write_func = 'imagepng';
                $image_quality = isset($options['png_quality']) ?
                    $options['png_quality'] : 9;
                break;
            default:
                return false;
        }
        $src_img = $this->gd_get_image_object(
            $file_path,
            $src_func,
            !empty($options['no_cache'])
        );
        $image_oriented = false;
        if (!empty($options['auto_orient']) && $this->gd_orient_image(
                $file_path,
                $src_img
            )) {
            $image_oriented = true;
            $src_img = $this->gd_get_image_object(
                $file_path,
                $src_func
            );
        }
        $max_width = $img_width = imagesx($src_img);
        $max_height = $img_height = imagesy($src_img);
        if (!empty($options['max_width'])) {
            $max_width = $options['max_width'];
        }
        if (!empty($options['max_height'])) {
            $max_height = $options['max_height'];
        }
        $scale = min(
            $max_width / $img_width,
            $max_height / $img_height
        );
        if ($scale >= 1) {
            if ($image_oriented) {
                return $write_func($src_img, $new_file_path, $image_quality);
            }
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        if (empty($options['crop'])) {
            $new_width = $img_width * $scale;
            $new_height = $img_height * $scale;
            $dst_x = 0;
            $dst_y = 0;
            $new_img = imagecreatetruecolor($new_width, $new_height);
        } else {
            if (($img_width / $img_height) >= ($max_width / $max_height)) {
                $new_width = $img_width / ($img_height / $max_height);
                $new_height = $max_height;
            } else {
                $new_width = $max_width;
                $new_height = $img_height / ($img_width / $max_width);
            }
            $dst_x = 0 - ($new_width - $max_width) / 2;
            $dst_y = 0 - ($new_height - $max_height) / 2;
            $new_img = imagecreatetruecolor($max_width, $max_height);
        }
        // Handle transparency in GIF and PNG images:
        switch ($type) {
            case 'gif':
            case 'png':
                imagecolortransparent($new_img, imagecolorallocate($new_img, 0, 0, 0));
            case 'png':
                imagealphablending($new_img, false);
                imagesavealpha($new_img, true);
                break;
        }
        $success = imagecopyresampled(
                $new_img,
                $src_img,
                $dst_x,
                $dst_y,
                0,
                0,
                $new_width,
                $new_height,
                $img_width,
                $img_height
            ) && $write_func($new_img, $new_file_path, $image_quality);
        $this->gd_set_image_object($file_path, $new_img);
        return $success;
    }
    protected function imagick_get_image_object($file_path, $no_cache = false) {
        if (empty($this->image_objects[$file_path]) || $no_cache) {
            $this->imagick_destroy_image_object($file_path);
            $image = new \Imagick();
            if (!empty($this->options['imagick_resource_limits'])) {
                foreach ($this->options['imagick_resource_limits'] as $type => $limit) {
                    $image->setResourceLimit($type, $limit);
                }
            }
            $image->readImage($file_path);
            $this->image_objects[$file_path] = $image;
        }
        return $this->image_objects[$file_path];
    }
    protected function imagick_set_image_object($file_path, $image) {
        $this->imagick_destroy_image_object($file_path);
        $this->image_objects[$file_path] = $image;
    }
    protected function imagick_destroy_image_object($file_path) {
        $image = (isset($this->image_objects[$file_path])) ? $this->image_objects[$file_path] : null ;
        return $image && $image->destroy();
    }
    protected function imagick_orient_image($image) {
        $orientation = $image->getImageOrientation();
        $background = new \ImagickPixel('none');
        switch ($orientation) {
            case \Imagick::ORIENTATION_TOPRIGHT: // 2
                $image->flopImage(); // horizontal flop around y-axis
                break;
            case \Imagick::ORIENTATION_BOTTOMRIGHT: // 3
                $image->rotateImage($background, 180);
                break;
            case \Imagick::ORIENTATION_BOTTOMLEFT: // 4
                $image->flipImage(); // vertical flip around x-axis
                break;
            case \Imagick::ORIENTATION_LEFTTOP: // 5
                $image->flopImage(); // horizontal flop around y-axis
                $image->rotateImage($background, 270);
                break;
            case \Imagick::ORIENTATION_RIGHTTOP: // 6
                $image->rotateImage($background, 90);
                break;
            case \Imagick::ORIENTATION_RIGHTBOTTOM: // 7
                $image->flipImage(); // vertical flip around x-axis
                $image->rotateImage($background, 270);
                break;
            case \Imagick::ORIENTATION_LEFTBOTTOM: // 8
                $image->rotateImage($background, 270);
                break;
            default:
                return false;
        }
        $image->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT); // 1
        return true;
    }
    protected function imagick_create_scaled_image($file_name, $version, $options) {
        list($file_path, $new_file_path) =
            $this->get_scaled_image_file_paths($file_name, $version);
        $image = $this->imagick_get_image_object(
            $file_path,
            !empty($options['crop']) || !empty($options['no_cache'])
        );
        if ($image->getImageFormat() === 'GIF') {
            // Handle animated GIFs:
            $images = $image->coalesceImages();
            foreach ($images as $frame) {
                $image = $frame;
                $this->imagick_set_image_object($file_name, $image);
                break;
            }
        }
        $image_oriented = false;
        if (!empty($options['auto_orient'])) {
            $image_oriented = $this->imagick_orient_image($image);
        }
        $new_width = $max_width = $img_width = $image->getImageWidth();
        $new_height = $max_height = $img_height = $image->getImageHeight();
        if (!empty($options['max_width'])) {
            $new_width = $max_width = $options['max_width'];
        }
        if (!empty($options['max_height'])) {
            $new_height = $max_height = $options['max_height'];
        }
        if (!($image_oriented || $max_width < $img_width || $max_height < $img_height)) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $crop = !empty($options['crop']);
        if ($crop) {
            $x = 0;
            $y = 0;
            if (($img_width / $img_height) >= ($max_width / $max_height)) {
                $new_width = 0; // Enables proportional scaling based on max_height
                $x = ($img_width / ($img_height / $max_height) - $max_width) / 2;
            } else {
                $new_height = 0; // Enables proportional scaling based on max_width
                $y = ($img_height / ($img_width / $max_width) - $max_height) / 2;
            }
        }
        $success = $image->resizeImage(
            $new_width,
            $new_height,
            isset($options['filter']) ? $options['filter'] : \Imagick::FILTER_LANCZOS,
            isset($options['blur']) ? $options['blur'] : 1,
            $new_width && $new_height // fit image into constraints if not to be cropped
        );
        if ($success && $crop) {
            $success = $image->cropImage(
                $max_width,
                $max_height,
                $x,
                $y
            );
            if ($success) {
                $success = $image->setImagePage($max_width, $max_height, 0, 0);
            }
        }
        $type = strtolower(substr(strrchr($file_name, '.'), 1));
        switch ($type) {
            case 'jpg':
            case 'jpeg':
                if (!empty($options['jpeg_quality'])) {
                    $image->setImageCompression(\Imagick::COMPRESSION_JPEG);
                    $image->setImageCompressionQuality($options['jpeg_quality']);
                }
                break;
        }
        if (!empty($options['strip'])) {
            $image->stripImage();
        }
        return $success && $image->writeImage($new_file_path);
    }
    protected function imagemagick_create_scaled_image($file_name, $version, $options) {
        list($file_path, $new_file_path) =
            $this->get_scaled_image_file_paths($file_name, $version);
        $resize = @$options['max_width']
            .(empty($options['max_height']) ? '' : 'X'.$options['max_height']);
        if (!$resize && empty($options['auto_orient'])) {
            if ($file_path !== $new_file_path) {
                return copy($file_path, $new_file_path);
            }
            return true;
        }
        $cmd = $this->options['convert_bin'];
        if (!empty($this->options['convert_params'])) {
            $cmd .= ' '.$this->options['convert_params'];
        }
        $cmd .= ' '.escapeshellarg($file_path);
        if (!empty($options['auto_orient'])) {
            $cmd .= ' -auto-orient';
        }
        if ($resize) {
            // Handle animated GIFs:
            $cmd .= ' -coalesce';
            if (empty($options['crop'])) {
                $cmd .= ' -resize '.escapeshellarg($resize.'>');
            } else {
                $cmd .= ' -resize '.escapeshellarg($resize.'^');
                $cmd .= ' -gravity center';
                $cmd .= ' -crop '.escapeshellarg($resize.'+0+0');
            }
            // Make sure the page dimensions are correct (fixes offsets of animated GIFs):
            $cmd .= ' +repage';
        }
        if (!empty($options['convert_params'])) {
            $cmd .= ' '.$options['convert_params'];
        }
        $cmd .= ' '.escapeshellarg($new_file_path);
        exec($cmd, $output, $error);
        if ($error) {
            error_log(implode('\n', $output));
            return false;
        }
        return true;
    }
    protected function get_image_size($file_path) {
        if ($this->options['image_library']) {
            if (extension_loaded('imagick')) {
                $image = new \Imagick();
                try {
                    if (@$image->pingImage($file_path)) {
                        $dimensions = array($image->getImageWidth(), $image->getImageHeight());
                        $image->destroy();
                        return $dimensions;
                    }
                    return false;
                } catch (\Exception $e) {
                    error_log($e->getMessage());
                }
            }
            if ($this->options['image_library'] === 2) {
                $cmd = $this->options['identify_bin'];
                $cmd .= ' -ping '.escapeshellarg($file_path);
                exec($cmd, $output, $error);
                if (!$error && !empty($output)) {
                    // image.jpg JPEG 1920x1080 1920x1080+0+0 8-bit sRGB 465KB 0.000u 0:00.000
                    $infos = preg_split('/\s+/', substr($output[0], strlen($file_path)));
                    $dimensions = preg_split('/x/', $infos[2]);
                    return $dimensions;
                }
                return false;
            }
        }
        if (!function_exists('getimagesize')) {
            error_log('Function not found: getimagesize');
            return false;
        }
        return @getimagesize($file_path);
    }
    protected function create_scaled_image($file_name, $version, $options) {
        if ($this->options['image_library'] === 2) {
            return $this->imagemagick_create_scaled_image($file_name, $version, $options);
        }
        if ($this->options['image_library'] && extension_loaded('imagick')) {
            return $this->imagick_create_scaled_image($file_name, $version, $options);
        }
        return $this->gd_create_scaled_image($file_name, $version, $options);
    }
    protected function destroy_image_object($file_path) {
        if ($this->options['image_library'] && extension_loaded('imagick')) {
            return $this->imagick_destroy_image_object($file_path);
        }
    }
    protected function is_valid_image_file($file_path) {
        if (!preg_match($this->options['image_file_types'], $file_path)) {
            return false;
        }
        if (function_exists('exif_imagetype')) {
            return @exif_imagetype($file_path);
        }
        $image_info = $this->get_image_size($file_path);
        return $image_info && $image_info[0] && $image_info[1];
    }
    protected function handle_image_file($file_path, $file) {
        $failed_versions = array();
        foreach ($this->options['image_versions'] as $version => $options) {
            if ($this->create_scaled_image($file->name, $version, $options)) {
                if (!empty($version)) {
                    $file->{$version.'Url'} = $this->get_download_url(
                        $file->name,
                        $version
                    );
                } else {
                    $file->size = $this->get_file_size($file_path, true);
                }
            } else {
                $failed_versions[] = $version ? $version : 'original';
            }
        }
        if (count($failed_versions)) {
            $file->error = $this->get_error_message('image_resize')
                .' ('.implode($failed_versions, ', ').')';
        }
        // Free memory:
        $this->destroy_image_object($file_path);
    }
    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error,
                                          $index = null, $content_range = null) {
        $file = new \stdClass();
        $file->name = $this->get_file_name($uploaded_file, $name, $size, $type, $error,
            $index, $content_range);
        $file->size = $this->fix_integer_overflow((int)$size);
        $file->type = $type;
        if ($this->validate($uploaded_file, $file, $error, $index)) {
            $this->handle_form_data($file, $index);
            $upload_dir = $this->get_upload_path();
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, $this->options['mkdir_mode'], true);
            }
            $file_path = $this->get_upload_path($file->name);
            $append_file = $content_range && is_file($file_path) &&
                $file->size > $this->get_file_size($file_path);
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                        $file_path,
                        fopen($uploaded_file, 'r'),
                        FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                    $file_path,
                    fopen($this->options['input_stream'], 'r'),
                    $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = $this->get_file_size($file_path, $append_file);
            if ($file_size === $file->size) {
                $file->url = $this->get_download_url($file->name);
                if ($this->is_valid_image_file($file_path)) {
                    $this->handle_image_file($file_path, $file);
                }
            } else {
                $file->size = $file_size;
                if (!$content_range && $this->options['discard_aborted_uploads']) {
                    unlink($file_path);
                    $file->error = $this->get_error_message('abort');
                }
            }
            $this->set_additional_file_properties($file);
        }
        return $file;
    }
    protected function readfile($file_path) {
        $file_size = $this->get_file_size($file_path);
        $chunk_size = $this->options['readfile_chunk_size'];
        if ($chunk_size && $file_size > $chunk_size) {
            $handle = fopen($file_path, 'rb');
            while (!feof($handle)) {
                echo fread($handle, $chunk_size);
                @ob_flush();
                @flush();
            }
            fclose($handle);
            return $file_size;
        }
        return readfile($file_path);
    }
    protected function body($str) {
        echo $str;
    }
    protected function header($str) {
        header($str);
    }
    protected function get_upload_data($id) {
        return @$_FILES[$id];
    }
    protected function get_post_param($id) {
        return @$_POST[$id];
    }
    protected function get_query_param($id) {
        return @$_GET[$id];
    }
    protected function get_server_var($id) {
        return @$_SERVER[$id];
    }
    protected function handle_form_data($file, $index) {
        // Handle form data, e.g. $_POST['description'][$index]
    }
    protected function get_version_param() {
        return $this->basename(stripslashes($this->get_query_param('version')));
    }
    protected function get_singular_param_name() {
        return substr($this->options['param_name'], 0, -1);
    }
    protected function get_file_name_param() {
        $name = $this->get_singular_param_name();
        return $this->basename(stripslashes($this->get_query_param($name)));
    }
    protected function get_file_names_params() {
        $params = $this->get_query_param($this->options['param_name']);
        if (!$params) {
            return null;
        }
        foreach ($params as $key => $value) {
            $params[$key] = $this->basename(stripslashes($value));
        }
        return $params;
    }
    protected function get_file_type($file_path) {
        switch (strtolower(pathinfo($file_path, PATHINFO_EXTENSION))) {
            case 'jpeg':
            case 'jpg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            default:
                return '';
        }
    }
    protected function download() {
        switch ($this->options['download_via_php']) {
            case 1:
                $redirect_header = null;
                break;
            case 2:
                $redirect_header = 'X-Sendfile';
                break;
            case 3:
                $redirect_header = 'X-Accel-Redirect';
                break;
            default:
                return $this->header('HTTP/1.1 403 Forbidden');
        }
        $file_name = $this->get_file_name_param();
        if (!$this->is_valid_file_object($file_name)) {
            return $this->header('HTTP/1.1 404 Not Found');
        }
        if ($redirect_header) {
            return $this->header(
                $redirect_header.': '.$this->get_download_url(
                    $file_name,
                    $this->get_version_param(),
                    true
                )
            );
        }
        $file_path = $this->get_upload_path($file_name, $this->get_version_param());
        // Prevent browsers from MIME-sniffing the content-type:
        $this->header('X-Content-Type-Options: nosniff');
        if (!preg_match($this->options['inline_file_types'], $file_name)) {
            $this->header('Content-Type: application/octet-stream');
            $this->header('Content-Disposition: attachment; filename="'.$file_name.'"');
        } else {
            $this->header('Content-Type: '.$this->get_file_type($file_path));
            $this->header('Content-Disposition: inline; filename="'.$file_name.'"');
        }
        $this->header('Content-Length: '.$this->get_file_size($file_path));
        $this->header('Last-Modified: '.gmdate('D, d M Y H:i:s T', filemtime($file_path)));
        $this->readfile($file_path);
    }
    protected function send_content_type_header() {
        $this->header('Vary: Accept');
        if (strpos($this->get_server_var('HTTP_ACCEPT'), 'application/json') !== false) {
            $this->header('Content-type: application/json');
        } else {
            $this->header('Content-type: text/plain');
        }
    }
    protected function send_access_control_headers() {
        $this->header('Access-Control-Allow-Origin: '.$this->options['access_control_allow_origin']);
        $this->header('Access-Control-Allow-Credentials: '
            .($this->options['access_control_allow_credentials'] ? 'true' : 'false'));
        $this->header('Access-Control-Allow-Methods: '
            .implode(', ', $this->options['access_control_allow_methods']));
        $this->header('Access-Control-Allow-Headers: '
            .implode(', ', $this->options['access_control_allow_headers']));
    }
    public function generate_response($content, $print_response = true) {
        $this->response = $content;
        if ($print_response) {
            $json = json_encode($content);
            $redirect = stripslashes($this->get_post_param('redirect'));
            if ($redirect && preg_match($this->options['redirect_allow_target'], $redirect)) {
                $this->header('Location: '.sprintf($redirect, rawurlencode($json)));
                return;
            }
            $this->head();
            if ($this->get_server_var('HTTP_CONTENT_RANGE')) {
                $files = isset($content[$this->options['param_name']]) ?
                    $content[$this->options['param_name']] : null;
                if ($files && is_array($files) && is_object($files[0]) && $files[0]->size) {
                    $this->header('Range: 0-'.(
                            $this->fix_integer_overflow((int)$files[0]->size) - 1
                        ));
                }
            }
            $this->body($json);
        }
        return $content;
    }
    public function get_response () {
        return $this->response;
    }
    public function head() {
        $this->header('Pragma: no-cache');
        $this->header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->header('Content-Disposition: inline; filename="files.json"');
        // Prevent Internet Explorer from MIME-sniffing the content-type:
        $this->header('X-Content-Type-Options: nosniff');
        if ($this->options['access_control_allow_origin']) {
            $this->send_access_control_headers();
        }
        $this->send_content_type_header();
    }
    public function get($print_response = true) {
        if ($print_response && $this->get_query_param('download')) {
            return $this->download();
        }
        $file_name = $this->get_file_name_param();
        if ($file_name) {
            $response = array(
                $this->get_singular_param_name() => $this->get_file_object($file_name)
            );
        } else {
            $response = array(
                $this->options['param_name'] => $this->get_file_objects()
            );
        }
        return $this->generate_response($response, $print_response);
    }
    public function post($print_response = true) {
        if ($this->get_query_param('_method') === 'DELETE') {
            return $this->delete($print_response);
        }
        $upload = $this->get_upload_data($this->options['param_name']);
        // Parse the Content-Disposition header, if available:
        $content_disposition_header = $this->get_server_var('HTTP_CONTENT_DISPOSITION');
        $file_name = $content_disposition_header ?
            rawurldecode(preg_replace(
                '/(^[^"]+")|("$)/',
                '',
                $content_disposition_header
            )) : null;
        // Parse the Content-Range header, which has the following form:
        // Content-Range: bytes 0-524287/2000000
        $content_range_header = $this->get_server_var('HTTP_CONTENT_RANGE');
        $content_range = $content_range_header ?
            preg_split('/[^0-9]+/', $content_range_header) : null;
        $size =  $content_range ? $content_range[3] : null;
        $files = array();
        if ($upload) {
            if (is_array($upload['tmp_name'])) {
                // param_name is an array identifier like "files[]",
                // $upload is a multi-dimensional array:
                foreach ($upload['tmp_name'] as $index => $value) {
                    $files[] = $this->handle_file_upload(
                        $upload['tmp_name'][$index],
                        $file_name ? $file_name : $upload['name'][$index],
                        $size ? $size : $upload['size'][$index],
                        $upload['type'][$index],
                        $upload['error'][$index],
                        $index,
                        $content_range
                    );
                }
            } else {
                // param_name is a single object identifier like "file",
                // $upload is a one-dimensional array:
                $files[] = $this->handle_file_upload(
                    isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                    $file_name ? $file_name : (isset($upload['name']) ?
                        $upload['name'] : null),
                    $size ? $size : (isset($upload['size']) ?
                        $upload['size'] : $this->get_server_var('CONTENT_LENGTH')),
                    isset($upload['type']) ?
                        $upload['type'] : $this->get_server_var('CONTENT_TYPE'),
                    isset($upload['error']) ? $upload['error'] : null,
                    null,
                    $content_range
                );
            }
        }
        $response = array($this->options['param_name'] => $files);
        return $this->generate_response($response, $print_response);
    }
    public function delete($print_response = true) {
        $file_names = $this->get_file_names_params();
        if (empty($file_names)) {
            $file_names = array($this->get_file_name_param());
        }
        $response = array();
        foreach ($file_names as $file_name) {
            $file_path = $this->get_upload_path($file_name);
            $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
            if ($success) {
                foreach ($this->options['image_versions'] as $version => $options) {
                    if (!empty($version)) {
                        $file = $this->get_upload_path($file_name, $version);
                        if (is_file($file)) {
                            unlink($file);
                        }
                    }
                }
            }
            $response[$file_name] = $success;
        }
        return $this->generate_response($response, $print_response);
    }
    protected function basename($filepath, $suffix = null) {
        $splited = preg_split('/\//', rtrim ($filepath, '/ '));
        return substr(basename('X'.$splited[count($splited)-1], $suffix), 1);
    }
}

class Uploader
{

    /**
     * @desc creates a zip file from the uploaded url and creates first page.
     * @param $pdfFile
     * @return array
     */
    public static function ContentsUploadFile($pdfFile)
    {
        $filePath = public_path('files/temp');
        if (File::extension($filePath . '/' . $pdfFile) != 'pdf') {
            return array(
                'fileName' => "",
                'imageFile' => ""
            );
        }

        //create zip archive
        $tempPdfFile = uniqid() . '.pdf';
        File::move($filePath . '/' . $pdfFile, $filePath . '/' . $tempPdfFile);
        $zipFile = $tempPdfFile . '.zip';

        $zip = new ZipArchive();
        $res = $zip->open($filePath . '/' . $zipFile, ZIPARCHIVE::CREATE);
        if ($res === true) {
            $zip->addFile($filePath . '/' . $tempPdfFile, 'file.pdf');
            $zip->close();
        }

        //create snapshot
        $imageFile = $tempPdfFile . '.jpg';
        $imageFileOriginal = $tempPdfFile . IMAGE_ORJ_EXTENSION;

        //create image with ghostscript from file
        //then use imagick
        $tempImageFile = uniqid() . ".jpg";

        $gsCommand = array();
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
        if ($im->getImageColorspace() == Imagick::COLORSPACE_CMYK) {

            $profiles = $im->getImageProfiles('*', false);

            // we're only interested if ICC profile(s) exist
            $has_icc_profile = (array_search('icc', $profiles) !== false);

            // if it doesnt have a CMYK ICC profile, we add one
            if ($has_icc_profile === false) {
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

        if (($geo['width'] / $width) < ($geo['height'] / $height)) {
            $im->cropImage($geo['width'], floor($height * $geo['width'] / $width), 0, (($geo['height'] - ($height * $geo['width'] / $width)) / 2));
        } else {
            $im->cropImage(ceil($width * $geo['height'] / $height), $geo['height'], (($geo['width'] - ($width * $geo['height'] / $height)) / 2), 0);
        }
        $im->ThumbnailImage($width, $height, true);
        $im->writeImage($filePath . '/' . $imageFile);
        $im->clear();
        $im->destroy();
        unset($im);

        //delete pdf file
        File::delete($filePath . '/' . $tempPdfFile);
        if (!empty($tempImageFile) && Laravel\File::exists($filePath . '/' . $tempImageFile)) {
            File::delete($filePath . '/' . $tempImageFile);
        }

        $tempPdfFile = $zipFile;
        return array(
            'fileName' => $tempPdfFile,
            'imageFile' => $imageFile
        );
    }

    public static function CmykControl($tempFile)
    {
        $filePath = public_path('files/temp/');
        if(File::extension($filePath . "/" . $tempFile) == "gif") {
            return;
        }

        $im = new \Imagick();
        $im->readImage($filePath . "/" . $tempFile);

        //convert color space to RGB
        //http://php.net/manual/en/imagick.setimagecolorspace.php
        if ($im->getImageColorspace() == Imagick::COLORSPACE_CMYK) {

            $profiles = $im->getImageProfiles('*', false);

            // we're only interested if ICC profile(s) exist
            $has_icc_profile = (array_search('icc', $profiles) !== false);

            // if it doesnt have a CMYK ICC profile, we add one
            if ($has_icc_profile === false) {
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

        if ($type == 'uploadpng1024x1024' || $type == 'uploadpng640x960' || $type == 'uploadpng640x1136' || $type == 'uploadpng1536x2048' || $type == 'uploadpng2048x1536') {
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

            if ($w != $width || $h != $height) {

                File::delete($filePath . "/" . $tempFile);

                throw new Exception('Invalid file dimension!');
            }
        }
    }

}
