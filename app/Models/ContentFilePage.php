<?php

namespace App\Models;

use App\Scopes\ContentFilePageScope;
use Auth;
use Common;
use DateTime;
use DB;
use eProcessTypes;
use eStatus;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ContentFilePage
 *
 * @property int $ContentFilePageID
 * @property int $ContentFileID
 * @property int $No
 * @property int $OperationStatus
 * @property float $Width
 * @property float $Height
 * @property string $FilePath
 * @property string $FileName
 * @property string $FileName2
 * @property int $FileSize
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PageComponent[] $PageComponents
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereContentFilePageID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereContentFileID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereOperationStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFilePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFileName2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFilePage whereProcessTypeID($value)
 * @mixin \Eloquent
 */
class ContentFilePage extends Model
{

    const Video = 1;
    const Audio = 2;
    const Map = 3;
    const Link = 4;
    const Web = 5;
    const Tooltip = 6;
    const Scroller = 7;
    const SlideShow = 8;
    const slide360 = 9;
    const Bookmark = 10;
    const Animation = 11;
    const OperationContinues = 1;
    const OperationAvailable = 0;
    public $timestamps = false;
    protected $table = 'ContentFilePage';
    public static $key = 'ContentFilePageID';
    protected $primaryKey = 'ContentFilePageID';

    protected static function boot() {
        parent::boot();
        static::addGlobalScope(new ContentFilePageScope);
    }

    /**
     * @param $contentFileID
     * @param $pageNo
     * @return ContentFilePage
     */
    public static function getPage($contentFileID, $pageNo)
    {
        return ContentFilePage::where('ContentFileID', '=', $contentFileID)
            ->where('No', '=', $pageNo)
            ->where('StatusID', '=', eStatus::Active)
            ->first();
    }

    /**
     * @param array $options
     * @return bool
     */
    public function save(array $options = [])
    {
        if (!$this->isDirty()) {
            return true;
        }
        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ($this->Height == 0 || $this->Width == 0) {
            $prevFilePage = $this->previousContentFilePage();
            if ($prevFilePage) {
                if ($this->Height == 0) {
                    $this->Height = $prevFilePage->Height;
                }
                if ($this->Width == 0) {
                    $this->Width = $prevFilePage->Width;
                }
            }
        }

        if ((int)$this->ContentFilePageID == 0) {
            $this->DateCreated = new DateTime();
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
            $this->ProcessTypeID = eProcessTypes::Insert;
        } else {
            $this->ProcessTypeID = eProcessTypes::Update;
        }

        $this->ProcessUserID = $userID;
        $this->ProcessDate = new DateTime();
        return parent::save($options);
    }

    /**
     * @return ContentFilePage
     */
    public function previousContentFilePage()
    {
        return ContentFilePage::where('ContentFileID', '=', $this->ContentFileID)
            ->where('No', '=', ($this->No - 1))
            ->first();
    }

    public function PageComponents()
    {
        return $this->hasMany(PageComponent::class, self::$key)->where('StatusID', '=', eStatus::Active);
    }


    private function removePageComponent($pageComponentID)
    {
        PageComponentProperty::where('PageComponentID', 'IN', DB::raw('(SELECT `PageComponentID` FROM `PageComponent` WHERE `PageComponentID`='
                . $pageComponentID . ' AND `ContentFilePageID`=' . $this->ContentFilePageID . ' AND `StatusID`=1)'))
            ->where('StatusID', '=', eStatus::Active)
            ->update(
                array(
                    'StatusID' => eStatus::Deleted,
                    'ProcessUserID' => Auth::user()->UserID,
                    'ProcessDate' => new DateTime(),
                    'ProcessTypeID' => eProcessTypes::Update
                )
            );

        PageComponent::getQuery()
            ->where('PageComponentID', '=', $pageComponentID)
            ->where('ContentFilePageID', '=', $this->ContentFilePageID)
            ->where('StatusID', '=', eStatus::Active)
            ->update(
                array(
                    'StatusID' => eStatus::Deleted,
                    'ProcessUserID' => Auth::user()->UserID,
                    'ProcessDate' => new DateTime(),
                    'ProcessTypeID' => eProcessTypes::Update
                )
            );
    }

    public function getPageComponentPropertiesAndValues($postData, $componentOrder)
    {
        $properties = array();
        foreach ($postData as $name => $value) {
            if (Common::startsWith($name, 'comp-' . $componentOrder)) {
                $name = str_replace('comp-' . $componentOrder . '-', "", $name);
                if (!in_array($name, PageComponent::$ignoredProperties)) {
                    $properties[$name] = $value;
                }
            }
        }
        return $properties;
    }

    public function nextPage()
    {
        return ContentFilePage::where('ContentFileID', '=', $this->ContentFileID)
            ->where('No', '=', $this->No + 1)
            ->where('StatusID', '=', eStatus::Active)
            ->first();
    }

    private function componentFactory($componentID, $componentPageOrder, $postData)
    {
        return;
//        $componentVideo = new ComponentVideo();
//        if ($componentID > 0) {
//            $pageComponent = PageComponent::find($componentID);
//            if (!$pageComponent) {
//                throw new Exception(__('error.compoenent_not_found'));
//            }
//            $componentVideo->pageComponent = $pageComponent;
//
//        } else {
//            $componentVideo->pageComponent = new PageComponent();
//        }
//
//        $properties = array();
//        foreach ($postData as $name => $value) {
//            if (Common::startsWith($name, 'comp-' . $componentPageOrder)) {
//                $name = str_replace('comp-' . $componentPageOrder . '-', "", $name);
//                if (!in_array($name, PageComponent::$ignoredProperties)) {
//                    $properties[$name] = $value;
//                }
//            }
//        }
//
//        $clientProcess = $request->get('comp-' . $componentPageOrder . '-process', '');
//
//        ///*********************************Eski Kod  **********************////
//
//
//        foreach ($ids as $id) {
//            //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
//            $clientComponentID = (int)$request->get('comp-' . $id . '-id', '0');
//            $componentID = (int)$request->get('comp-' . $id . '-pcid', '0');
//            $clientProcess = $request->get('comp-' . $id . '-process', '');
//
//            if ($clientProcess == 'new' || $clientProcess == 'loaded') {
//                $tPageComponentExists = false;
//
//                if ($clientProcess == 'loaded' && $componentID > 0) {
//                    $tPageComponentExists = true;
//                    $pageComponent = PageComponent::find($componentID);
//                } else {
//                    $pageComponent = new PageComponent();
//                }
//
//                $pageComponent->ContentFilePageID = $contentFilePageID;
//                $pageComponent->ComponentID = $clientComponentID;
//                $pageComponent->No = $id;
//                $pageComponent->save();
//
//                //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
//                if ($tPageComponentExists) {
//                    //wtf neden statusu deleted yapiyor ????
//                    DB::table('PageComponentProperty')
//                        ->where('PageComponentID', '=', $pageComponent->PageComponentID)
//                        ->where('StatusID', '=', eStatus::Active)
//                        ->update(
//                            array(
//                                'StatusID' => eStatus::Deleted,
//                                'ProcessUserID' => $currentUser->UserID,
//                                'ProcessDate' => new DateTime(),
//                                'ProcessTypeID' => eProcessTypes::Update
//                            )
//                        );
//                }
//                //Log::info('logInfo -- ' . 'line:' . __LINE__ . ' time:' . microtime());
//
//                foreach ($componentProperties[$id] as $name => $value) {
//                    //Log::info('line:' . __LINE__ . ' comp:' . $name . ' time:' . microtime());
//
//                    //slideshow || gallery360
//                    if (($name == 'file' || $name == 'filename' || $name == 'filename2') && is_array($value)) {
//                        $index = 1;
//
//                        foreach ($value as $v) {
//                            if (Str::length($v) > 0) {
//                                $sourcePath = 'files/temp';
//                                $sourcePathFull = path('public') . $sourcePath;
//                                $sourceFile = $v;
//                                $sourceFileNameFull = $sourcePathFull . '/' . $sourceFile;
//
//                                $targetPath = 'files/customer_' . $customerID . '/application_' . $applicationID . '/content_' . $contentID . '/file_' . $contentFileID . '/output/comp_' . $pageComponent->PageComponentID;
//                                $targetPathFull = path('public') . $targetPath;
//                                $targetFile = $currentUser->UserID . '_' . date("YmdHis") . '_' . $v;
//                                //360
//                                if ($clientComponentID == 9) {
//                                    $targetFile = ($index < 10 ? '0' . $index : '' . $index) . '.jpg';
//                                }
//                                $targetFileNameFull = $targetPathFull . '/' . $targetFile;
//
//                                if (!File::exists($targetPathFull)) {
//                                    File::mkdir($targetPathFull);
//                                }
//
//                                if (File::exists($sourceFileNameFull)) {
//                                    File::move($sourceFileNameFull, $targetFileNameFull);
//                                    $v = $targetPath . '/' . $targetFile;
//                                } else {
//                                    $oldValue = DB::table('PageComponentProperty')
//                                        ->where('PageComponentID', '=', $pageComponent->PageComponentID)
//                                        ->where('Name', '=', $name)
//                                        ->where('Value', 'LIKE', '%' . $v)
//                                        ->where('StatusID', '=', eStatus::Deleted)
//                                        orderBy'PageComponentPropertyID', 'DESC')
//                                        ->first(array('Value'));
//                                    if ($oldValue) {
//                                        $v = $oldValue->Value;
//                                    } else {
//                                        $v = $targetPath . '/' . $v;
//                                    }
//                                    //TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
//                                    //$v = $targetPath.'/'.$v;
//                                }
//
//                                $pcp = new PageComponentProperty();
//                                $pcp->PageComponentID = $pageComponent->PageComponentID;
//                                $pcp->Name = $name;
//                                $pcp->Value = $v;
//                                $pcp->StatusID = eStatus::Active;
//                                $pcp->CreatorUserID = $currentUser->UserID;
//                                $pcp->DateCreated = new DateTime();
//                                $pcp->ProcessUserID = $currentUser->UserID;
//                                $pcp->ProcessDate = new DateTime();
//                                $pcp->ProcessTypeID = eProcessTypes::Insert;
//                                $pcp->save();
//
//                                $index = $index + 1;
//                            }
//                        }
//                    } else {
//                        if (($name == 'file' || $name == 'filename' || $name == 'filename2' || $name == 'posterimagename' || $name == 'modaliconname') && Str::length($value) > 0) {
//                            $sourcePath = 'files/temp';
//                            $sourcePathFull = path('public') . $sourcePath;
//                            $sourceFile = $value;
//                            $sourceFileNameFull = $sourcePathFull . '/' . $sourceFile;
//
//                            $targetPath = 'files/customer_' . $customerID . '/application_' . $applicationID . '/content_' . $contentID . '/file_' . $contentFileID . '/output/comp_' . $pageComponent->PageComponentID;
//                            $targetPathFull = path('public') . $targetPath;
//                            $targetFile = $currentUser->UserID . '_' . date("YmdHis") . '_' . $value;
//                            $targetFileNameFull = $targetPathFull . '/' . $targetFile;
//
//                            if (!File::exists($targetPathFull)) {
//                                File::mkdir($targetPathFull);
//                            }
//
//                            if (File::exists($sourceFileNameFull)) {
//                                File::move($sourceFileNameFull, $targetFileNameFull);
//                                $value = $targetPath . '/' . $targetFile;
//                            } else {
//                                $oldValue = DB::table('PageComponentProperty')
//                                    ->where('PageComponentID', '=', $pageComponent->PageComponentID)
//                                    ->where('Name', '=', $name)
//                                    ->where('StatusID', '=', eStatus::Deleted)
//                                    orderBy'PageComponentPropertyID', 'DESC')
//                                    ->first(array('Value'));
//
//                                if ($oldValue) {
//                                    $value = $oldValue->Value;
//                                } else {
//                                    $value = $targetPath . '/' . $value;
//                                }
//                                //TODO:kaydete bastiktan sonra ikinci kez kaydete basilirsa veriler bozuluyor !!!
//                                //$value = $targetPath.'/'.$value;
//                            }
//                        }
//
//                        if ($name == 'url' && !Common::startsWith($value, 'http://') && !Common::startsWith($value, 'https://') && !empty($value)) {
//                            $value = 'http://' . $value;
//                        }
//                        $value = str_replace("www.youtube.com/watch?v=", "www.youtube.com/embed/", $value);
//
//                        $pcp = new PageComponentProperty();
//                        $pcp->PageComponentID = $pageComponent->PageComponentID;
//                        $pcp->Name = $name;
//                        $pcp->Value = $value;
//                        $pcp->StatusID = eStatus::Active;
//                        $pcp->CreatorUserID = $currentUser->UserID;
//                        $pcp->DateCreated = new DateTime();
//                        $pcp->ProcessUserID = $currentUser->UserID;
//                        $pcp->ProcessDate = new DateTime();
//                        $pcp->ProcessTypeID = eProcessTypes::Insert;
//                        $pcp->save();
//                    }
//
//                }
//            }
//        }
//

    }
    //
}
