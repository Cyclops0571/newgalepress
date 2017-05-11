<?php

use App\Models\Application;
use App\Models\Component;
use App\Models\Content;
use App\Models\ContentFile;
use App\Models\ContentPassword;
use App\Models\Requestt;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Str;


abstract class Interactivity {

    const ProcessAvailable = 0;
    const ProcessQueued = 1;
    const ProcessContinues = 2;
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

abstract class eRequestType {

    const NORMAL_IMAGE_FILE = 1101;
    const SMALL_IMAGE_FILE = 1102;
    const PDF_FILE = 1001;
}

abstract class eUserTypes {

    const Manager = 101;
    const Customer = 111;
}

abstract class eProcessTypes {

    const Insert = 51;
    const Update = 52;
    const Delete = 53;
}

class eServiceError {

    const ServiceNotFound = 1;
    const ServiceMethodObsolete = 2;
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
        switch ($errorNo)
        {
            case eServiceError::ServiceNotFound:
                $exception = new Exception("Servis versiyonu hatalı", $errorNo);
                break;
            case eServiceError::ServiceMethodObsolete:
                $exception = new Exception('Servis methodu artık kullanılmıyor.');
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
                $exception = new Exception(env('APP_URL') . " adresinden hesap oluşturmalısınız.", $errorNo);
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

class Subscription {

    const week = 1;
    const mounth = 2;
    const year = 3;

    public static function types()
    {
        return [
            1 => "week_subscription",
            2 => "month_subscription",
            3 => "year_subscription",
        ];
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
function __($key, $replacements = [], $language = null)
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
    $result = [];

    foreach ($array as $key => $value)
    {
        $key = stripslashes($key);

        // If the value is an array, we will just recurse back into the
        // function to keep stripping the slashes out of the array,
        // otherwise we will set the stripped value.
        if (is_array($value))
        {
            $result[$key] = array_strip_slashes($value);
        } else
        {
            $result[$key] = stripslashes($value);
        }
    }

    return $result;
}

class Common {

    public static function htmlOddEven($name)
    {
        static $status = [];

        if (!isset($status[$name]))
        {
            $status[$name] = 0;
        }

        $status[$name] = 1 - $status[$name];

        return ($status[$name] % 2 == 0) ? 'even' : 'odd';
    }

    public static function dirsize($dir)
    {
        if (is_file($dir))
            return filesize($dir);
        if ($dh = opendir($dir))
        {
            $size = 0;
            while (($file = readdir($dh)) !== false)
            {
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
        return str_replace(['&', '<', '>', '\'', '"'], ['&amp;', '&lt;', '&gt;', '&apos;', '&quot;'], $string);
    }

    public static function CheckCategoryOwnership($categoryID)
    {
        $currentUser = Auth::user();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer)
        {
            $count = DB::table('Customer AS c')
                ->join('Application AS a', function (JoinClause $join)
                {
                    $join->on('a.CustomerID', '=', 'c.CustomerID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('Category AS t', function (JoinClause $join) use ($categoryID)
                {
                    $join->on('t.CategoryID', '=', DB::raw($categoryID));
                    $join->on('t.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('t.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where('c.CustomerID', '=', $currentUser->CustomerID)
                ->where('c.StatusID', '=', eStatus::Active)
                ->count();
            if ($count > 0)
            {
                return true;
            }

            return false;
        } else
        {
            return true;
        }
    }

    public static function CheckCategoryOwnershipWithApplication($applicationID, $categoryID)
    {
        $currentUser = Auth::user();

        $chk4Application = Common::CheckApplicationOwnership($applicationID);

        if ($chk4Application)
        {
            if ((int)$currentUser->UserTypeID == eUserTypes::Customer)
            {
                $count = DB::table('Customer AS c')
                    ->join('Application AS a', function (JoinClause $join) use ($applicationID)
                    {
                        $join->on('a.ApplicationID', '=', DB::raw($applicationID));
                        $join->on('a.CustomerID', '=', 'c.CustomerID');
                        $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                    })
                    ->join('Category AS t', function (JoinClause $join) use ($categoryID)
                    {
                        $join->on('t.CategoryID', '=', DB::raw($categoryID));
                        $join->on('t.ApplicationID', '=', 'a.ApplicationID');
                        $join->on('t.StatusID', '=', DB::raw(eStatus::Active));
                    })
                    ->where('c.CustomerID', '=', $currentUser->CustomerID)
                    ->where('c.StatusID', '=', eStatus::Active)
                    ->count();
                if ($count > 0)
                {
                    return true;
                }
            } else
            {
                $count = DB::table('Category')
                    ->where('CategoryID', '=', $categoryID)
                    ->where('ApplicationID', '=', $applicationID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->count();
                if ($count > 0)
                {
                    return true;
                }
            }
        }

        return false;
    }

    public static function CheckApplicationOwnership($applicationID)
    {
        $currentUser = Auth::user();
        if ($currentUser == null)
        {
            return false;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Manager)
        {
            return true;
        }

        if ((int)$applicationID == 0)
        {
            return false;
        }

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer)
        {
            $a = Application::find($applicationID);
            if ($a)
            {
                if ((int)$a->StatusID == eStatus::Active)
                {
                    $c = $a->Customer;
                    if ((int)$c->StatusID == eStatus::Active)
                    {
                        if ((int)$currentUser->CustomerID == (int)$c->CustomerID)
                        {
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

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer)
        {
            $count = DB::table('Customer AS c')
                ->join('Application AS a', function (JoinClause $join)
                {
                    $join->on('a.CustomerID', '=', 'c.CustomerID');
                    $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('Content AS cn', function (JoinClause $join)
                {
                    $join->on('cn.ApplicationID', '=', 'a.ApplicationID');
                    $join->on('cn.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->join('ContentPassword AS cp', function (JoinClause $join) use ($contentPasswordID)
                {
                    $join->on('cp.ContentPasswordID', '=', DB::raw($contentPasswordID));
                    $join->on('cp.ContentID', '=', 'cn.ContentID');
                    $join->on('cp.StatusID', '=', DB::raw(eStatus::Active));
                })
                ->where('c.CustomerID', '=', $currentUser->CustomerID)
                ->where('c.StatusID', '=', eStatus::Active)
                ->count();
            if ($count > 0)
            {
                return true;
            }

            return false;
        } else
        {
            return true;
        }
    }

    public static function AuthInteractivity($applicationID)
    {
        if (Common::CheckApplicationOwnership($applicationID))
        {
            $a = Application::find($applicationID);
            if ($a)
            {
                return (1 == (int)$a->Package->Interactive);
            }
        }

        return false;
    }

    public static function AuthMaxPDF($applicationID)
    {
        if (Common::CheckApplicationOwnership($applicationID))
        {
            $currentPDF = (int)Content::where('ApplicationID', '=', $applicationID)->where('Status', '=', 1)->where('StatusID', '=', eStatus::Active)->count();
            $a = Application::find($applicationID);
            if ($a)
            {
                $maxPDF = (int)Application::find($applicationID)->Package->MaxActivePDF;
                if ($currentPDF < $maxPDF)
                {
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
            ->join('Application AS a', function (JoinClause $join)
            {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->join('Content AS o', function (JoinClause $join) use ($ContentID)
            {
                $join->on('o.ContentID', '=', DB::raw($ContentID));
                $join->on('o.ApplicationID', '=', 'a.ApplicationID');
                $join->on('o.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->where('c.StatusID', '=', eStatus::Active)
            ->first(['c.CustomerID', 'a.ApplicationID', 'o.ContentID', 'o.IsProtected']);
        if ($c)
        {
            $oCustomerID = (int)$c->CustomerID;
            $oApplicationID = (int)$c->ApplicationID;
            $oContentID = (int)$c->ContentID;
            $IsProtected = (int)$c->IsProtected;
            if ($IsProtected == 1)
            {
                //Content
                $authPwd = false;
                $checkPwd = DB::table('Content')
                    ->where('ContentID', '=', $oContentID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->first();
                if ($checkPwd)
                {
                    $authPwd = Hash::check($Password, $checkPwd->Password);
                }
                //Content password
                $authPwdList = false;
                $checkPwdList = DB::table('ContentPassword')
                    ->where('ContentID', '=', $oContentID)
                    ->where('StatusID', '=', eStatus::Active)
                    ->get();
                if ($checkPwdList)
                {
                    foreach ($checkPwdList as $pwd)
                    {
                        if ((int)$pwd->Qty > 0)
                        {
                            if (Hash::check($Password, $pwd->Password))
                            {
                                $authPwdList = true;
                                //dec counter
                                $current = ContentPassword::find($pwd->ContentPasswordID);
                                if ((int)$current->Qty > 0)
                                {
                                    $current->Qty = $current->Qty - 1;
                                    $current->save();
                                }
                                break;
                            }
                        }
                    }
                }

                if (!($authPwd || $authPwdList))
                {
                    throw new Exception(__('common.contents_wrongpassword'), "101");
                }
            }

            $cf = ContentFile::getQuery()
                ->where('ContentID', '=', $oContentID)
                ->where('StatusID', '=', eStatus::Active)
                ->orderBy('ContentFileID', 'DESC')
                ->first();
            if ($cf)
            {
                $oContentFileID = (int)$cf->ContentFileID;
                $oContentFilePath = $cf->FilePath;
                $oContentFileName = $cf->FileName;

                if ((int)$cf->Interactivity == Interactivity::ProcessQueued)
                {
                    if ((int)$cf->HasCreated == 1)
                    {
                        $oContentFilePath = $cf->InteractiveFilePath;
                        $oContentFileName = $cf->InteractiveFileName;
                    } else
                    {
                        throw new Exception(__('common.contents_interactive_file_hasnt_been_created'), "104");
                    }
                }
            } else
            {
                throw new Exception(__('common.list_norecord'), "102");
            }
        } else
        {
            throw new Exception(__('common.list_norecord'), "102");
        }
    }

    public static function download($RequestTypeID, $CustomerID, $ApplicationID, $ContentID, $ContentFileID, $ContentCoverImageFileID, $filepath, $filename)
    {
        $file = public_path($filepath . '/' . $filename);

        if (file_exists($file) && is_file($file))
        {
            $fileSize = File::size($file);
            //throw new Exception($fileSize);

            $r = new Requestt();
            $r->RequestTypeID = $RequestTypeID;
            $r->CustomerID = $CustomerID;
            $r->ApplicationID = $ApplicationID;
            $r->ContentID = $ContentID;
            $r->ContentFileID = $ContentFileID;
            if ($ContentCoverImageFileID > 0)
            {
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
            header("Cache-Control: post-check=0, pre-check=0", false);
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

            while (!feof($fc) && connection_status() == 0)
            {

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
        } else
        {
            throw new Exception(__('common.file_notfound'), "102");
        }
    }

    public static function downloadImage($ContentID, $RequestTypeID, $Width, $Height)
    {
        $content = DB::table('Customer AS c')
            ->join('Application AS a', function (JoinClause $join)
            {
                $join->on('a.CustomerID', '=', 'c.CustomerID');
                $join->on('a.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->join('Content AS o', function (JoinClause $join) use ($ContentID)
            {
                $join->on('o.ContentID', '=', DB::raw($ContentID));
                $join->on('o.ApplicationID', '=', 'a.ApplicationID');
                $join->on('o.StatusID', '=', DB::raw(eStatus::Active));
            })
            ->where('c.StatusID', '=', eStatus::Active)
            ->first(['c.CustomerID', 'a.ApplicationID', 'o.ContentID', 'o.IsProtected']);
        if (!$content)
        {
            throw new Exception(__('common.list_norecord'), "102");
        }
        $contentFile = DB::table('ContentFile')
            ->where('ContentID', '=', $ContentID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentFileID', 'DESC')
            ->first();

        if (!$contentFile)
        {
            throw new Exception(__('common.list_norecord'), "102");
        }
        $contentCoverImageFile = DB::table('ContentCoverImageFile')
            ->where('ContentFileID', '=', $contentFile->ContentFileID)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentCoverImageFileID', 'DESC')
            ->first();
        if (!$contentCoverImageFile)
        {
            throw new Exception(__('common.list_norecord'), "102");
        }

        if ($Width > 0 && $Height > 0)
        {
            //image var mi kontrol edip yok ise olusturup, ismini set edelim;
            $originalImage = public_path($contentCoverImageFile->FilePath . '/' . IMAGE_CROPPED_2048);
            if (!is_file($originalImage))
            {
                $originalImage = public_path($contentCoverImageFile->FilePath . '/' . $contentCoverImageFile->SourceFileName);
            }
            $pathInfoOI = pathinfo($originalImage);
            $fileName = IMAGE_CROPPED_NAME . "_" . $Width . "x" . $Height . ".jpg";
            if (!is_file($pathInfoOI["dirname"] . "/" . $fileName))
            {
                //resize original image to new path and then save it.
                if (!is_file($originalImage))
                {
                    throw new Exception(__('common.file_notfound'), "102");
                }
                $im = new Imagick($originalImage);
                $im->resizeImage($Width, $Height, Imagick::FILTER_LANCZOS, 1);
                $im->writeImage($pathInfoOI["dirname"] . "/" . $fileName);
                $im->destroy();
            }
        } else
        {
            switch ($RequestTypeID)
            {
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
        if (!is_file($file))
        {
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
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: " . GMDATE("D, d M Y H:i:s", MKTIME(DATE("H") + 2, DATE("i"), DATE("s"), DATE("m"), DATE("d"), DATE("Y"))) . " GMT");
        header("Last-Modified: " . GMDATE("D, d M Y H:i:s") . " GMT");
        header("Content-Type: application/octet-stream");
        header("Content-Length: " . $fileSize);
        header('Content-Disposition: inline; filename="' . str_replace(" ", "_", $fileName) . '"'); //dosya isminde bosluk varsa problem oluyor!!!
        header("Content-Transfer-Encoding: binary\n");
        // open file stream
        $fc = fopen($file, "r");
        while (!feof($fc) && connection_status() == 0)
        {
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


    public static function generatePassword($length = 6, $level = 2)
    {
        list($usec, $sec) = explode(' ', microtime());
        srand((float)$sec + ((float)$usec * 100000));

        $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
        $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

        $password = "";
        $counter = 0;

        while ($counter < $length)
        {
            $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level]) - 1), 1);

            // All character must be different
            if (!strstr($password, $actChar))
            {
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
        if (empty($date))
        {
            $date = date("Y-m-d");
        }
        $ret = date('Y-m-d H:i:s', strtotime($date));
        if ($useLocal)
        {
            $ret = Common::convert2Localzone($ret, true);
        }

        return $ret;
    }

    public static function convert2Localzone($d, $write = false)
    {
        //2009-07-14 04:27:16
        if (Auth::check())
        {
            $sign = '+';
            $hour = 0;
            $minute = 0;

            $timezone = Auth::user()->Timezone;
            $timezone = str_replace('UTC', '', $timezone);
            $timezone = preg_replace('/\s+/', '', $timezone);
            //var_dump($timezone);

            if (mb_strlen($timezone) > 0)
            {

                $sign = substr($timezone, 0, 1);
                $timezone = str_replace($sign, '', $timezone);
                $pos = strrpos($timezone, ":");
                if ($pos === false)
                {
                    //yok
                    $hour = (int)$timezone;
                } else
                {
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

            if ($write)
            {
                if ($sign == '+')
                {
                    $sign = '-';
                } else
                {
                    $sign = '+';
                }
            }

            if ($hour > 0)
            {
                $date = new DateTime($d);
                $d = date("Y-m-d H:i:s", strtotime($sign . $hour . ' hours', $date->getTimestamp()));
            }

            if ($minute > 0)
            {
                $date = new DateTime($d);
                $d = date("Y-m-d H:i:s", strtotime($sign . $minute . ' minutes', $date->getTimestamp()));
            }
            //var_dump($d);
        }

        return $d;
    }

    public static function getFormattedData($data, $type)
    {
        //$FieldTypeVariant
        //Number
        //String
        //Percent
        //DateTime
        //Date
        //Bit
        if ($type == "Number")
        {
            $ret = $data;
        } elseif ($type == "String")
        {
            if (Common::startsWith($data, '!!!'))
            {
                $ret = trans('common.' . str_replace('!!!', '', $data));
            } else
            {
                $ret = $data;
            }
        } elseif ($type == "Percent")
        {
            $ret = '% ' . round((float)$data, 2);
        } elseif ($type == "DateTime")
        {
            $ret = Common::dateRead($data, "dd.MM.yyyy HH:mm");
        } elseif ($type == "Date")
        {
            $ret = Common::dateRead($data, "dd.MM.yyyy");
        } elseif ($type == "Bit")
        {
            $ret = ((int)$data == 1 ? "Evet" : "Hayır");
        } elseif ($type == "Size")
        {

            $size = (float)$data;
            $s = "Byte";

            if ($size > 1024)
            {

                $size = $size / 1024;
                $s = "KB";

                if ($size > 1024)
                {

                    $size = $size / 1024;
                    $s = "MB";

                    if ($size > 1024)
                    {

                        $size = $size / 1024;
                        $s = "GB";

                        if ($size > 1024)
                        {

                            $size = $size / 1024;
                            $s = "TB";
                        }
                    }
                }
            }
            $size = number_format($size, 2, '.', '');
            $ret = $size . " " . $s;
        } else
        {
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
        if (empty($date))
        {
            $date = date("Y-m-d");
        }
        if ($useLocal)
        {
            $date = Common::convert2Localzone($date);
        }

        if (App::isLocale('usa'))
        {
            if ($format == 'd.m.Y')
            {
                $format = 'm/d/Y';
            } else if ($format == 'd.m.Y H:i')
            {
                $format = 'm/d/Y H:i';
            } else if ($format == 'd.m.Y H:i:s')
            {
                $format = 'm/d/Y H:i:s';
            }
        }

        return date($format, strtotime($date));
    }

    public static function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0)
        {
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

        if ($type == 'country')
        {
            $isCountry = true;
            $column = 'Country';
        } elseif ($type == 'city')
        {
            $isCity = true;
            $column = 'City';
        } elseif ($type == 'district')
        {
            $isDistrict = true;
            $column = 'District';
        }

        $rs = DB::table('Statistic')
            ->where(function (Builder $query) use ($currentUser, $isCountry, $isCity, $isDistrict, $customerID, $applicationID, $contentID, $country, $city)
            {
                if ((int)$currentUser->UserTypeID == eUserTypes::Manager && $customerID > 0)
                {
                    $query->where('CustomerID', '=', $customerID);
                } elseif ((int)$currentUser->UserTypeID == eUserTypes::Customer)
                {
                    $query->where('CustomerID', '=', $currentUser->CustomerID);
                }

                if ($applicationID > 0)
                {
                    if (Common::CheckApplicationOwnership($applicationID))
                    {
                        $query->where('ApplicationID', '=', $applicationID);
                    }
                }

                if ($contentID > 0)
                {
                    if (Common::CheckContentOwnership($contentID))
                    {
                        $query->where('ContentID', '=', $contentID);
                    }
                }

                if ($isCity)
                {
                    $query->where('Country', '=', (strlen($country) > 0 ? $country : '???'));
                } elseif ($isDistrict)
                {
                    $query->where('Country', '=', (strlen($country) > 0 ? $country : '???'));
                    $query->where('City', '=', (strlen($city) > 0 ? $city : '???'));
                }
            })
            ->distinct()
            ->orderBy($column, 'ASC')
            ->get([$column]);

        return $rs;
    }

    public static function CheckContentOwnership($contentID)
    {
        $currentUser = Auth::user();

        if ((int)$currentUser->UserTypeID == eUserTypes::Customer)
        {
            $content = Content::find($contentID);
            if ($content)
            {
                if ((int)$content->StatusID == eStatus::Active)
                {
                    if ((int)$content->Application->StatusID == eStatus::Active)
                    {
                        $c = $content->Application->Customer;
                        if ((int)$c->StatusID == eStatus::Active)
                        {
                            if ((int)$currentUser->CustomerID == (int)$c->CustomerID)
                            {
                                return true;
                            }
                        }
                    }
                }
            }

            return false;
        } else
        {
            return true;
        }
    }

    public static function toExcel($twoDimensionalArray, $toFile)
    {
        $rows = [];
        $sep = "\t";
        foreach ($twoDimensionalArray as $row)
        {
            $tmpStr = "";
            foreach ($row as $cell)
            {
                $r = "";
                if ($cell != "")
                {
                    $r .= "$cell" . $sep;
                } else
                {
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
        foreach ($postData as $key => $value)
        {
            if (empty($postDataString))
            {
                $postDataString .= $key . "=" . $value;
            } else
            {
                $postDataString .= '&' . $key . "=" . $value;
            }
        }

        return $postDataString;
    }

    public static function localize($key, $replacements = [], $language = null)
    {
        $action = app('request')->route()->getAction();

        $result = trans(class_basename($action['controller']) . '.' . $key, $replacements, 'messages', $language);
        if (empty($result))
        {
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
        switch (app()->getLocale())
        {
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
        foreach ($exception->getTrace() as $frame)
        {
            $args = "";
            if (isset($frame['args']))
            {
                $args = [];
                foreach ($frame['args'] as $arg)
                {
                    if (is_string($arg))
                    {
                        $args[] = "'" . $arg . "'";
                    } elseif (is_array($arg))
                    {
                        $args[] = "Array";
                    } elseif (is_null($arg))
                    {
                        $args[] = 'NULL';
                    } elseif (is_bool($arg))
                    {
                        $args[] = ($arg) ? "true" : "false";
                    } elseif (is_object($arg))
                    {
                        $args[] = get_class($arg);
                    } elseif (is_resource($arg))
                    {
                        $args[] = get_resource_type($arg);
                    } else
                    {
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
        foreach ($sourceProperties as $sourceProperty)
        {
            $name = $sourceProperty->getName();
            if (gettype($destination->{$name}) == "object")
            {
                self::Cast($destination->{$name}, $source->$name);
            } else
            {
                $destination->{$name} = $source->$name;
            }
        }
    }

    public static function getLocaleId()
    {
        $langs = config('app.langs');

        return $langs[App::getLocale()];
    }

    public static function getClass($row)
    {
        if (isset($row->IsMaster) && $row->IsMaster == 1)
        {
            return ' class="masterContentRow"';
        }

        return '';
    }
}


function localDateFormat($format = 'dd.MM.yyyy')
{
    $currentLang = app()->getLocale();
    if ($currentLang == 'usa' && $format == 'dd.MM.yyyy')
    {
        return 'mm/dd/yyyy';
    }
    return $format;
}

function ip_info($ip = null, $purpose = "location", $deep_detect = true)
{
    $output = null;
    if (!isset($_SERVER["REMOTE_ADDR"]))
    {
        return $output;
    }
    if (filter_var($ip, FILTER_VALIDATE_IP) === false)
    {
        $ip = $_SERVER["REMOTE_ADDR"];
        if ($deep_detect)
        {
            if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
            if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP))
                $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
    }
    $purpose = str_replace(["name", "\n", "\t", " ", "-", "_"], null, strtolower(trim($purpose)));
    $support = ["country", "countrycode", "state", "region", "city", "location", "address"];
    $continents = [
        "AF" => "Africa",
        "AN" => "Antarctica",
        "AS" => "Asia",
        "EU" => "Europe",
        "OC" => "Australia (Oceania)",
        "NA" => "North America",
        "SA" => "South America",
    ];
    if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support))
    {
        $ipdat = @json_decode(file_get_contents("http://www.geoplugin.net/json.gp?ip=" . $ip));
        if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2)
        {
            switch ($purpose)
            {
                case "location":
                    $output = [
                        "city"           => @$ipdat->geoplugin_city,
                        "state"          => @$ipdat->geoplugin_regionName,
                        "country"        => @$ipdat->geoplugin_countryName,
                        "country_code"   => @$ipdat->geoplugin_countryCode,
                        "continent"      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                        "continent_code" => @$ipdat->geoplugin_continentCode,
                    ];
                    break;
                case "address":
                    $address = [$ipdat->geoplugin_countryName];
                    if (@strlen($ipdat->geoplugin_regionName) >= 1)
                        $address[] = $ipdat->geoplugin_regionName;
                    if (@strlen($ipdat->geoplugin_city) >= 1)
                        $address[] = $ipdat->geoplugin_city;
                    $output = implode(", ", array_reverse($address));
                    break;
                case "city":
                    $output = @$ipdat->geoplugin_city;
                    break;
                case "state":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "region":
                    $output = @$ipdat->geoplugin_regionName;
                    break;
                case "country":
                    $output = @$ipdat->geoplugin_countryName;
                    break;
                case "countrycode":
                    $output = @$ipdat->geoplugin_countryCode;
                    break;
            }
        }
    }

    return $output;
}

function interactiveComponents()
{
    return Component::orderBy('DisplayOrder', 'ASC')->get();
}