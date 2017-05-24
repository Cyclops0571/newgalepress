<?php

namespace App\Models;

use App\Library\ImageClass;
use App\Scopes\StatusScope;
use Auth;
use eStatus;
use File;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Banner
 *
 * @property int $BannerID
 * @property int $ApplicationID
 * @property int $OrderNo
 * @property string $ImagePublicPath
 * @property string $ImageLocalPath
 * @property string $TargetUrl
 * @property string $TargetContent
 * @property string $Description
 * @property int $Version
 * @property int $Status
 * @property int $StatusID
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Application $Application
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereBannerID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereImageLocalPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereImagePublicPath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereTargetContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereTargetUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Banner whereVersion($value)
 * @mixin \Eloquent
 */
class Banner extends Model
{


    protected $table = 'Banner';
    protected $primaryKey = 'BannerID';
    public static $key = 'BannerID';
    public static $slideAnimations = array("slide", "fade", "cube", "coverflow", "flip");

    protected static function boot()
    {
        parent::boot();
        self::addGlobalScope(new StatusScope);
    }

    /**
     *
     * @param int $applicationID
     * @param bool $showPassive
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public static function getAppBanner($applicationID, $showPassive = true)
    {
        if ($showPassive) {
            return Banner::where("ApplicationID", $applicationID)
                ->orderBy("OrderNo", "Desc")
                ->get();

        }

        return Banner::where("ApplicationID", $applicationID)
            ->where("Status", eStatus::Active)
            ->orderBy("OrderNo", "Desc")
            ->get();
    }

    /**
     *
     * @param string $tmpFileName
     * @return void
     */
    public function processImage($tmpFileName)
    {
        $application = $this->Application;
        $tmpFilePath = public_path(PATH_TEMP_FILE . '/' . $tmpFileName);
        $destinationFolder = public_path('files/customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/banner/');
        $sourcePicturePath = $destinationFolder . Auth::user()->UserID . '_' . date("YmdHis") . '_' . $tmpFileName;
        if (!is_file($tmpFilePath)) {
            return;
        }

        if (!File::exists($destinationFolder)) {
            File::makeDirectory($destinationFolder);
        }

        File::move($tmpFilePath, $sourcePicturePath);

        if(File::extension($sourcePicturePath) == 'gif') {
            $this->ImagePublicPath = '/files/customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/banner/' . $this->BannerID . ".gif";
            $this->ImageLocalPath = $destinationFolder . $this->BannerID . ".gif";
            $this->save();
            File::copy($sourcePicturePath, $destinationFolder . "/" . $this->BannerID . ".gif");
            return;
        }

        $this->ImagePublicPath = '/files/customer_' . $application->CustomerID . '/application_' . $application->ApplicationID . '/banner/' . $this->BannerID . IMAGE_EXTENSION;
        $this->ImageLocalPath = $destinationFolder . $this->BannerID . IMAGE_EXTENSION;
        $this->save();

        $pictureInfoSet = array();
        $pictureInfoSet[] = array("width" => 1480, "height" => 640, "imageName" => $this->BannerID);
        foreach ($pictureInfoSet as $pInfo) {
            ImageClass::cropImage($sourcePicturePath, $destinationFolder, $pInfo["width"], $pInfo["height"], $pInfo["imageName"], FALSE);
        }
    }

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Application()
    {
        return $this->belongsTo(Application::class, 'ApplicationID');
    }

    public function save(array $option = [])
    {

        if ($this->isClean()) {
            return;
        }

        if ($this->BannerID == 0) {
            $this->StatusID = eStatus::Active;
        }
        $this->Version = (int)$this->Version + 1;
        $this->Application->incrementAppVersion();
        parent::save();
    }

    public function statusText()
    {
        return __('common.banners_list_status' . $this->Status);
    }

    public function getImagePath()
    {
        if(empty($this->ImagePublicPath)) {
            if(!$this->BannerID) {
                return '';
            }
            $destinationFolder = public_path('files/customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/banner/');
            $this->ImagePublicPath = '/files/customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/banner/' . $this->BannerID . IMAGE_EXTENSION;
            $this->ImageLocalPath = $destinationFolder . $this->BannerID . IMAGE_EXTENSION;
            if(!File::exists($this->ImageLocalPath)) {
                if (!File::exists($destinationFolder)) {
                    File::makeDirectory($destinationFolder);
                }
                File::copy(public_path('images/upload_image.png'), $this->ImageLocalPath);
            }
            $this->save();

        }
        return $this->ImagePublicPath;
    }

}
