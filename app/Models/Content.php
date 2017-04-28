<?php

namespace App\Models;

use App\Library\ImageClass;
use Auth;
use Common;
use Config;
use Cookie;
use DateTime;
use DB;
use eProcessTypes;
use eRemoveFromMobile;
use eStatus;
use eUserTypes;
use File;
use Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

/**
 * App\Models\Content
 *
 * @property int $ContentID
 * @property int $ApplicationID
 * @property int $OrderNo
 * @property string $Name
 * @property string $Detail
 * @property string $MonthlyName
 * @property string $PublishDate
 * @property int $IsUnpublishActive
 * @property string $UnpublishDate
 * @property int $IsProtected
 * @property string $Password
 * @property int $IsBuyable
 * @property float $Price
 * @property int $CurrencyID
 * @property int $IsMaster
 * @property bool $Orientation
 * @property string $Identifier
 * @property int $AutoDownload
 * @property int $Approval
 * @property int $Blocked
 * @property int $Status
 * @property int $RemoveFromMobile
 * @property int $Version
 * @property int $PdfVersion
 * @property int $CoverImageVersion
 * @property int $TotalFileSize
 * @property int $TopicStatus
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @property-read \App\Models\Application $Application
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $Category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentCategory[] $ContentCategory
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentFile[] $ContentFile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentTopic[] $ContentTopics
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereApplicationID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereApproval($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereAutoDownload($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereBlocked($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereCoverImageVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereCurrencyID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIdentifier($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsBuyable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsMaster($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsProtected($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereIsUnpublishActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereMonthlyName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereOrderNo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereOrientation($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePdfVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereProcessTypeID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content wherePublishDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereRemoveFromMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereTopicStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereTotalFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereUnpublishDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Content whereVersion($value)
 * @mixin \Eloquent
 */
class Content extends Model {

    public $timestamps = false;
    protected $table = 'Content';
    protected $primaryKey = 'ContentID';
    public static $key = 'ContentID';

    const defaultSort = 'OrderNo';

    public static function contentList(Request $request)
    {

        //$applicationID, $search, $p, $option, $sort, $sort_dir
        $applicationID = $request->get('applicationID', 0);
        $search = $request->get('search', '');
        $sort = $request->get('sort', self::defaultSort);
        $sort_dir = $request->get('sort_dir', 'DESC');
        $sqlCat = '(IFNULL((SELECT GROUP_CONCAT(`Name` ORDER BY `Name` SEPARATOR \', \')'
            . ' FROM `Category` WHERE ApplicationID=a.ApplicationID AND CategoryID IN '
            . '(SELECT CategoryID FROM `ContentCategory` WHERE ContentID = o.ContentID) AND StatusID = 1), \'\'))';

        $sql = '' .
            'SELECT ' .
            'c.CustomerID, ' .
            'c.CustomerName, ' .
            'o.OrderNo,' .
            'o.Detail,' .
            'o.MonthlyName,' .
            'a.ApplicationID, ' .
            'a.Name AS ApplicationName, ' .
            'o.Name, ' .
            '(' .
            'CASE WHEN (SELECT COUNT(*) FROM `ContentCategory` WHERE ContentID = o.ContentID AND CategoryID = 0) > 0 ' .
            'THEN CONCAT(\'' . __('common.contents_category_list_general') . ', \', ' . $sqlCat . ') ' .
            'ELSE ' . $sqlCat . ' ' .
            'END' .
            ') AS CategoryName, ' .
            'o.PublishDate, ' .
            'o.UnpublishDate, ' .
            'o.IsMaster, ' .
            '(CASE o.Blocked WHEN 1 THEN \'' . __('common.contents_list_blocked1') . '\' ELSE \'' . __('common.contents_list_blocked0') . '\' END) AS Blocked, ' .
            '(CASE WHEN ('
            . 'o.Status = 1 AND '
            . '(o.PublishDate <= CURDATE()) AND '
            . '(o.IsUnpublishActive = 0 OR o.UnpublishDate > CURDATE())) '
            . 'THEN \'' . __('common.contents_list_status1') . '\' ' .
            'ELSE \'' . __('common.contents_list_status0') . '\' END) AS Status, ' .
            'o.ContentID ' .
            'FROM `Customer` AS c ' .
            'INNER JOIN `Application` AS a ON a.CustomerID=c.CustomerID AND a.StatusID=1 ' .
            'INNER JOIN `Content` AS o ON o.ApplicationID=a.ApplicationID AND o.StatusID=1 ' .
            'WHERE c.StatusID=1';
        $rs = DB::table(DB::raw('(' . $sql . ') t'))
            ->where(function (Builder $query) use ($applicationID, $search)
            {
                if ((int)Auth::user()->UserTypeID == eUserTypes::Manager)
                {
                    if ($applicationID > 0)
                    {
                        $query->where('ApplicationID', '=', $applicationID);
                    }

                    if (strlen(trim($search)) > 0)
                    {
                        $query->where(function (Builder $q) use ($search)
                        {
                            $q->where('CustomerName', 'LIKE', '%' . $search . '%');
                            $q->orWhere('ApplicationName', 'LIKE', '%' . $search . '%');
                            $q->orWhere('Blocked', 'LIKE', '%' . $search . '%');
                            $q->orWhere('Status', 'LIKE', '%' . $search . '%');
                            $q->orWhere('ContentID', 'LIKE', '%' . $search . '%');
                        });
                    }
                } elseif (Auth::user()->UserTypeID == eUserTypes::Customer)
                {
                    if (Common::CheckApplicationOwnership($applicationID))
                    {
                        if (strlen(trim($search)) > 0)
                        {
                            $query->where('ApplicationID', '=', $applicationID);
                            $query->where(function (Builder $q) use ($search)
                            {
                                $q->where('Name', 'LIKE', '%' . $search . '%');
                                $q->orWhere('CategoryName', 'LIKE', '%' . $search . '%');
                                $q->orWhere('PublishDate', 'LIKE', '%' . $search . '%');
                                $q->orWhere('Blocked', 'LIKE', '%' . $search . '%');
                                $q->orWhere('Status', 'LIKE', '%' . $search . '%');
                                $q->orWhere('ContentID', 'LIKE', '%' . $search . '%');
                            });
                        } else
                        {
                            $query->where('ApplicationID', '=', $applicationID);
                        }
                    } else
                    {
                        $query->where('ApplicationID', '=', -1);
                    }
                }
            })
            ->orderBy($sort, $sort_dir);
        if ($sort != self::defaultSort)
        {
            $rs->orderBy(self::defaultSort, 'DESC');
        }

        $rows = $rs->paginate(config('custom.rowcount'));
        return $rows;

    }


    public function Application()
    {
        return $this->belongsTo(Application::class, 'ApplicationID');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function Category()
    {
        return $this->belongsToMany(Category::class, 'ContentCategory', self::$key, Category::$key);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ContentCategory()
    {
        return $this->hasMany(ContentCategory::class, 'ContentID');
    }

    public function Currency($languageID)
    {
        $gc = GroupCode::where('GroupCodeID', '=', $this->CurrencyID)->first();
        if ($gc)
        {
            return $gc->getDisplayName($languageID);
        }

        return '';
    }

    public function Files($statusID = eStatus::Active)
    {
        return $this->hasMany(ContentFile::class, self::$key)->getQuery()->where('StatusID', '=', $statusID)->get();
    }

    public function ActiveFile()
    {
        return $this->hasMany(ContentFile::class, self::$key)->getQuery()->where('StatusID', '=', eStatus::Active)->first();
    }

    public function setPassword($password)
    {
        if (strlen(trim($password)) > 0)
        {
            $this->Password = Hash::make(request('Password'));
        }
    }

    public function setMaster($isMaster)
    {
        $this->IsMaster = $isMaster;
        if ($isMaster)
        {
            //Unset IsProtected & password field due to https://github.com/galepress/gp/issues/7
            $this->IsProtected = 0;
            $this->Password = '';
            $contents = Content::where('ApplicationID', '=', $this->ApplicationID)->get();
            foreach ($contents as $content)
            {
                //INFO:Added due to https://github.com/galepress/gp/issues/18
                if ((int)$this->ContentID !== (int)$content->ContentID)
                {
                    $a = Content::find($content->ContentID);
                    $a->IsMaster = 0;
                    $a->Version = (int)$a->Version + 1;
                    $a->ProcessUserID = Auth::user()->UserID;
                    $a->ProcessDate = new DateTime();
                    $a->ProcessTypeID = eProcessTypes::Update;
                    $a->save();
                }
            }
        }
    }

    /**
     *
     * @param int $contentID
     * @param array $columns
     * @return Content
     */
    public static function find($contentID, $columns = ['*'])
    {
        return Content::where(self::$key, "=", $contentID)->first($columns);
    }

    public function save(array $options = [])
    {
        if (!isset($options['updateAppVersion']))
        {
            $options['updateAppVersion'] = true;
        }

        $userID = -1;
        if (Auth::user())
        {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->ContentID == 0)
        {
            $this->DateCreated = new DateTime();
            $this->ProcessTypeID = eProcessTypes::Insert;
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
            $this->PdfVersion = 1;
            $this->CoverImageVersion = 1;
        } else
        {
            $this->ProcessTypeID = eProcessTypes::Update;
        }

        $this->ProcessUserID = $userID;
        $this->Version = (int)$this->Version + 1;
        $this->ProcessDate = new DateTime();
        if ($options['updateAppVersion'])
        {
            $contentApp = Application::find($this->ApplicationID);
            if ($contentApp)
            {
                $contentApp->incrementAppVersion();
            }
        }

        return parent::save();
    }

    /**
     * @return ContentFile
     */
    public function processPdf()
    {
        if ((int)request('hdnFileSelected', 0) != 1)
        {
            return ContentFile::where('ContentID', '=', $this->ContentID)
                ->where('StatusID', '=', eStatus::Active)
                ->orderBy('ContentFileID', 'DESC')
                ->first();
        }


        $ContentFile = null;
        $sourceFileName = request('hdnFileName');
        $sourceFilePath = 'files/temp';
        $sourceRealPath = public_path($sourceFilePath);
        $sourceFileNameFull = $sourceRealPath . '/' . $sourceFileName;

        $targetFileName = Auth::user()->UserID . '_' . date("YmdHis") . '_' . $sourceFileName;
        $targetFilePath = 'files/customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/content_' . $this->ContentID;
        $destinationFolder = public_path($targetFilePath);
        $targetFileNameFull = $destinationFolder . '/' . $targetFileName;

        if (File::exists($sourceFileNameFull))
        {
            if (!File::exists($destinationFolder))
            {
                File::makeDirectory($destinationFolder, 0777, true);
            }

            $this->PdfVersion += 1;
            $this->save();

            $originalImageFileName = pathinfo($sourceFileNameFull, PATHINFO_FILENAME) . IMAGE_ORJ_EXTENSION;
            File::move($sourceFileNameFull, $targetFileNameFull);
            if (File::exists($sourceRealPath . "/" . $originalImageFileName))
            {
                File::move($sourceRealPath . "/" . $originalImageFileName, $destinationFolder . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION);
            }


            $ContentFile = new ContentFile();
            $ContentFile->ContentID = $this->ContentID;
            $ContentFile->DateAdded = new DateTime();
            $ContentFile->FilePath = $targetFilePath;
            $ContentFile->FileName = $targetFileName;
            $ContentFile->FileSize = File::size($targetFileNameFull);
            $ContentFile->Transferred = (int)request('Transferred', '0');
            $ContentFile->StatusID = eStatus::Active;
            $ContentFile->CreatorUserID = Auth::user()->UserID;
            $ContentFile->DateCreated = new DateTime();
            $ContentFile->ProcessUserID = Auth::user()->UserID;
            $ContentFile->ProcessDate = new DateTime();
            $ContentFile->ProcessTypeID = eProcessTypes::Insert;
            $ContentFile->save();
        }

        return $ContentFile;
    }

    /**
     * @desc Calls an outer service for indexing pdfs
     * @param ContentFile $contentFile
     */
    public function callIndexingService(ContentFile $contentFile)
    {
        //http://37.9.205.205/indexing?path=customer_127/application_135/content_5207/file_6688/file.pdf'

        $contentFile->Indexed = 0;
        $pdfPath = 'customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/content_' . $this->ContentID . '/file_' . $contentFile->ContentFileID . '/file.pdf';
        $requestUrl = 'http://37.9.205.205/indexing?path=' . $pdfPath;
        @$ch = curl_init($requestUrl);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        if (!empty($result))
        {
            $resultJson = json_decode($result, true);
            if (isset($resultJson['status']) && $resultJson['status'] == 1)
            {
                $contentFile->Indexed = 1;
            }
        }

        if ($contentFile->Indexed == 0)
        {
            $error = new ServerErrorLog();
            $error->ErrorMessage = "Indexing error - ContentFileID: " . $contentFile->ContentFileID . " -  response: " . json_encode($result);
            $error->Parameters = $requestUrl;
            $error->save();
        }
        $contentFile->save();
    }

    /**
     * @param ContentFile $contentFile
     * @param int $coverImageFileSelected
     * @param string $coverImageFileName
     */
    public function processImage(ContentFile $contentFile, $coverImageFileSelected, $coverImageFileName)
    {

        if ($coverImageFileSelected != 1)
        {
            return;
        }

        $sourceFileName = $coverImageFileName;
        $sourceFilePath = 'files/temp';
        $sourceRealPath = public_path($sourceFilePath);
        $sourceFileNameFull = $sourceRealPath . '/' . $sourceFileName;

        $targetFileName = Auth::user()->UserID . '_' . date("YmdHis") . '_' . $sourceFileName;
        $targetFilePath = 'files/customer_' . $this->Application->CustomerID . '/application_' . $this->ApplicationID . '/content_' . $this->ContentID;
        $destinationFolder = public_path($targetFilePath);
        $targetFileNameFull = $destinationFolder . '/' . $targetFileName;

        $targetMainFileName = $targetFileName . '_main';
        $targetThumbFileName = $targetFileName . '_thumb';

        if (File::exists($sourceFileNameFull) && is_file($sourceFileNameFull))
        {
            if (!File::exists($destinationFolder))
            {
                File::makeDirectory($destinationFolder, 0777, true);
            }


            //<editor-fold desc="Delete Old Images">
            foreach (scandir($destinationFolder . "/") as $fileName)
            {
                if (substr($fileName, 0, strlen(IMAGE_CROPPED_NAME)) === IMAGE_CROPPED_NAME)
                {
                    unlink($destinationFolder . "/" . $fileName);
                }
            }
            //</editor-fold>

            File::move($sourceFileNameFull, $targetFileNameFull);
            if ((int)request('hdnFileSelected', 0) == 0)
            {
                sleep(1);
                File::copy($targetFileNameFull, $destinationFolder . '/' . IMAGE_ORIGINAL . IMAGE_EXTENSION);
            }
            $pictureInfoSet = [];
            $pictureInfoSet[] = ["width" => 110, "height" => 157, "imageName" => $targetMainFileName];
            $pictureInfoSet[] = ["width" => 468, "height" => 667, "imageName" => $targetThumbFileName];
            foreach ($pictureInfoSet as $pInfo)
            {
                ImageClass::cropImage($targetFileNameFull, $destinationFolder, $pInfo["width"], $pInfo["height"], $pInfo["imageName"], false);
            }

            $cropSet = Crop::get();
            $sourceFile = $destinationFolder . "/" . IMAGE_ORIGINAL . IMAGE_EXTENSION;
            foreach ($cropSet as $crop)
            {
                //create neccessary image versions
                ImageClass::cropImage($sourceFile, $destinationFolder, $crop->Width, $crop->Height);
            }

            $this->CoverImageVersion += 1;
            $this->save();

            $c = new ContentCoverImageFile();
            $c->ContentFileID = $contentFile->ContentFileID;
            $c->DateAdded = new DateTime();
            $c->FilePath = $targetFilePath;
            $c->SourceFileName = $targetFileName;
            $c->FileName = $targetMainFileName . IMAGE_EXTENSION;
            $c->FileName2 = $targetThumbFileName . IMAGE_EXTENSION;
            $c->FileSize = File::size($destinationFolder . "/" . $targetMainFileName . ".jpg");
            $c->StatusID = eStatus::Active;
            $c->CreatorUserID = Auth::user()->UserID;
            $c->DateCreated = new DateTime();
            $c->ProcessUserID = Auth::user()->UserID;
            $c->ProcessDate = new DateTime();
            $c->ProcessTypeID = eProcessTypes::Insert;
            $c->save();
            Cookie::make(SHOW_IMAGE_CROP, SHOW_IMAGE_CROP);
        }
    }

    public function getIdentifier($refreshIdentifier = false)
    {
        if (!$this->ContentID)
        {
            return $this->Identifier;
        }
        if (empty($this->Identifier) || $refreshIdentifier)
        {
            if (empty($this->Application->BundleText))
            {
                $identifier = "www.galepress.com." . $this->ContentID . "t" . time();
            } else
            {
                $identifier = strtolower($this->Application->BundleText) . "." . $this->ContentID . "t" . time();
            }
            if (empty($this->Identifier))
            {
                $this->Identifier = $identifier;
                $this->save();
            } else
            {
                $this->Identifier = $identifier;
            }
        }

        return $this->Identifier;
    }


    public function ContentTopics()
    {
        return $this->hasMany(ContentTopic::class, 'ContentID');
    }

    /**
     * @desc Saves Topic - Content relations to ContentTopic table
     * @param array $topicIds
     */
    public function setTopics($topicIds)
    {
        if ($this->TopicStatus != eStatus::Active)
        {
            return;
        }

        if (empty($topicIds))
        {
            foreach ($this->ContentTopics as $contentTopic)
            {
                $contentTopic->delete();
            }

            return;
        }
        $myTopicIds = [];
        foreach ($this->ContentTopics as $contentTopic)
        {
            $myTopicIds[] = $contentTopic->TopicID;
        }


        foreach ($topicIds as $topicId)
        {
            foreach ($this->ContentTopics as $contentTopic)
            {
                if (!in_array($contentTopic->TopicID, $topicIds))
                {
                    $contentTopic->delete();
                }
            }
            if (!in_array($topicId, $myTopicIds))
            {
                $contentTopic = new ContentTopic();
                $contentTopic->ContentID = $this->ContentID;
                $contentTopic->TopicID = $topicId;
                $contentTopic->save();
            }
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ContentFile()
    {
        return $this->hasMany(ContentFile::class, 'ContentID');
    }


    public function serveContent()
    {
        $serveContent = $this->PublishDate <= date("Y-m-d H:i:s");
        $serveContent = $serveContent && ($this->IsUnpublishActive == 0 || $this->UnpublishDate > date("Y-m-d"));
        $serveContent = $serveContent || ($this->RemoveFromMobile == eRemoveFromMobile::Active);

        return $serveContent;
    }

    public function getServiceData($addStatusCode = true)
    {
        $result = [
            'ContentID'                => (int)$this->ContentID,
            'ApplicationID'            => (int)$this->ApplicationID,
            'ContentOrderNo'           => (int)$this->OrderNo,
            'ContentName'              => $this->Name,
            'ContentDetail'            => $this->Detail,
            'ContentMonthlyName'       => $this->MonthlyName,
            'ContentIsProtected'       => ((int)$this->IsProtected == 1 ? true : false),
            'ContentIsBuyable'         => ((int)$this->IsBuyable == 1 ? true : false),
            'ContentPrice'             => '',
            'ContentCurrency'          => $this->Currency(1),
            'ContentIdentifier'        => $this->getIdentifier(),
            'ContentIsMaster'          => ((int)$this->IsMaster == 1 ? true : false),
            'ContentOrientation'       => (int)$this->Orientation,
            'ContentAutoDownload'      => ((int)$this->AutoDownload == 1 ? true : false),
            'ContentBlocked'           => (bool)$this->Blocked,
            'ContentStatus'            => (bool)$this->Status,
            'ContentVersion'           => (int)$this->Version,
            'ContentPdfVersion'        => (int)$this->PdfVersion,
            'ContentCoverImageVersion' => (int)$this->CoverImageVersion,
            'RemoveFromMobile'         => (bool)$this->RemoveFromMobile,
        ];
        if ($addStatusCode)
        {
            $status = [];
            $status["status"] = 0;
            $status["error"] = "";
            $result = array_merge($result, $status);
        }

        return $result;
    }

    public function getServiceDataDetailed()
    {

        $mappedCategories = $this->Category->map(function (Category $category)
        {
            return ['CategoryID' => $category->CategoryID, 'CategoryName' => $category->Name];
        })->toArray();

        return array_merge($this->getServiceData(), ['ContentCategories' => $mappedCategories]);
    }

    /**
     * @param int[] $contentIds
     * @return Content[]|\Illuminate\Support\Collection
     */
    public static function getAccessibleContents($contentIds)
    {
        if (empty($contentIds))
        {
            return [];
        }

        return Content::whereIn('ContentID', $contentIds)
            ->where('StatusID', '=', eStatus::Active)
            ->where('PublishDate', '<=', DB::raw('now()'))
            ->where(function (Builder $query)
            {
                $query->where('IsUnpublishActive', '=', 0);
                $query->orWhere('UnpublishDate', '>', DB::raw('now()'));
            })
            ->orderBy('OrderNo', 'DESC')
            ->orderBy('MonthlyName', 'ASC')
            ->orderBy('Name', 'ASC')->get();
    }

    /**
     * @param int[] $contentIds
     * @return Content[]|\Illuminate\Support\Collection
     */
    public static function getAccessibleTopicContents($contentIds)
    {
        if (empty($contentIds))
        {
            return [];
        }

        return Content::whereIn('Content.ContentID', $contentIds)
            ->where('StatusID', '=', eStatus::Active)
            ->where('PublishDate', '<=', DB::raw('now()'))
            ->where(function (Builder $query)
            {
                $query->where('IsUnpublishActive', '=', 0);
                $query->orWhere('UnpublishDate', '>', DB::raw('now()'));
            })
            ->join('ContentTopic', 'Content.ContentID', '=', 'ContentTopic.ContentID')
            ->orderBy('OrderNo', 'DESC')
            ->orderBy('MonthlyName', 'ASC')
            ->orderBy('Name', 'ASC')->get();
    }

    public function getMonthlyName()
    {
        if ($this->ContentID)
        {
            return $this->MonthlyName;
        }

        return Common::monthName((int)date('m')) . ' ' . date('Y');

    }

    public function hasContentCategory($categoryID)
    {
        $categoryIds = $this->ContentCategory->pluck('CategoryID')->toArray();
        return in_array($categoryID, $categoryIds);
    }
}
