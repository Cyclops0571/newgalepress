<?php

namespace App\Models;

use Auth;
use Common;
use DateTime;
use eProcessTypes;
use eStatus;
use Exception;
use File;
use Illuminate\Database\Eloquent\Model;
use Imagick;
use Interactivity;
use ZipArchive;

/**
 * App\Models\ContentFile
 *
 * @property int $ContentFileID
 * @property int $ContentID
 * @property string $DateAdded
 * @property string $FilePath
 * @property string $FileName
 * @property string $FileName2
 * @property int $FileSize
 * @property int $PageCreateProgress
 * @property int $Transferred
 * @property int $Interactivity
 * @property int $HasCreated
 * @property int $ErrorCount
 * @property string $LastErrorDetail
 * @property string $InteractiveFilePath
 * @property string $InteractiveFileName
 * @property string $InteractiveFileName2
 * @property int $InteractiveFileSize
 * @property int $TotalFileSize
 * @property int $Included
 * @property int $Indexed
 * @property int $StatusID
 * @property int $CreatorUserID
 * @property string $DateCreated
 * @property int $ProcessUserID
 * @property string $ProcessDate
 * @property int $ProcessTypeID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereContentFileID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereContentID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereDateAdded($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereFilePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereFileName2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile wherePageCreateProgress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereTransferred($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereInteractivity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereHasCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereErrorCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereLastErrorDetail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereInteractiveFilePath($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereInteractiveFileName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereInteractiveFileName2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereInteractiveFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereTotalFileSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereIncluded($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereIndexed($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereStatusID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereCreatorUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereDateCreated($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereProcessUserID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereProcessDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ContentFile whereProcessTypeID($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Content $Content
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentCoverImageFile[] $ContentCoverImageFile
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ContentFilePage[] $ContentFilePages
 */
class ContentFile extends Model
{
    const ContentFileInUse = 1;
    const ContentFileAvailable = 0;
    public $timestamps = false;
    protected $table = 'ContentFile';
    protected $primaryKey = 'ContentFileID';
    public static $key = 'ContentFileID';
    private $_pfdName = '';

    /**
     * After pdf uploaded this function creates page snap shots, bookmarks and annotation
     * @param ContentFile $cf
     * @return string|void
     */
    public static function createPdfPages(ContentFile &$cf)
    {
        if (!$cf) {
            return;
        }

        $expMessage = '';
        if (count($cf->ContentFilePages) > 0) {
            //contentFile is already interactive.
            return;
        }

        $cf->PageCreateProgress = ContentFile::ContentFileInUse;
        $cf->save();


        //create folder if does not exist
        if (!File::exists($cf->pdfFolderPathAbsolute())) {
            File::makeDirectory($cf->pdfFolderPathAbsolute(), 777, true);
        }

        try {
            $targetFileNameFull = public_path($cf->FilePath . '/' . $cf->FileName);
            //extract zip file
            $zip = new ZipArchive();
            $res = $zip->open($targetFileNameFull);
            if ($res === true) {
                $zip->extractTo($cf->pdfFolderPathAbsolute());
                $zip->close();
            }
            $pdfFileNameFull = $cf->pdfFolderPathAbsolute() . '/' . $cf->getPdfName();

            $myPcos = new MyPcos($pdfFileNameFull);
            $cf->createPdfSnapShots();
            $myPcos->checkPageSnapshots();
            for ($i = 0; $i < $myPcos->pageCount(); $i++) {
                $cfp = new ContentFilePage();
                $cfp->ContentFileID = $cf->ContentFileID;
                $cfp->No = $i + 1;
                $cfp->Width = $myPcos->width($i);
                $cfp->Height = $myPcos->height($i);
                $cfp->FilePath = $cf->pdfFolderPathRelative();
                $cfp->FileName = $myPcos->getImageFileName($i);
                $cfp->FileSize = File::size($cf->pdfFolderPathAbsolute() . '/' . $cfp->FileName);
                $cfp->save();
                if ($cf->Transferred != 1) {
                    $myPcos->arrangeBookmarkNew($cfp);
                    $myPcos->arrangeAnnotationNew($cfp, $i);
                }

            }
            $cf = ContentFile::find($cf->ContentFileID);
            $cf->comparePages();
            $myPcos->closePdf();
        } catch (PDFlibException $e) {
            $expMessage = "PDFlib exception occurred in :<br/>" .
                "File:" . $e->getFile() . "<br/>" .
                "Line:" . $e->getLine() . "<br/>" .
                "[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " . $e->get_errmsg();
        } catch (Exception $e) {
            $expMessage = "File:" . $e->getFile() . "\r\n";
            $expMessage .= "Line:" . $e->getLine() . "\r\n";
            $expMessage .= "Message:" . $e->getMessage() . "\r\n";
        }
//        $cf->PageCreateProgress  = ContentFile::ContentFileAvailable;
//        $cf->save();
        return $expMessage;
    }

    public function Content()
    {
        return $this->belongsTo(Content::class, 'ContentID');
    }

    private function createOutputFolder()
    {
        if (!File::exists($this->pdfFolderPathAbsolute() . '/output')) {
            File::makeDirectory($this->pdfFolderPathAbsolute() . '/output', 777, true);
        }
    }

    public function createInteractivePdf()
    {
        $ApplicationID = $this->Content->ApplicationID;
        try {
            //-----------------------------------------------------------------------------------------------

            $path = $this->pdfFolderPathAbsolute();

            //find pdf file
            $pdfFile = '';
            $files = scandir($path);
            foreach ($files as $file) {
                if (is_file($path . '/' . $file) && Common::endsWith($file, '.pdf')) {
                    $pdfFile = $file;
                    break;
                }
            }
            $fileOriginal = $path . "/" . $pdfFile;

            $baseRelativePath = $this->pdfFolderPathRelative() . '/output';
            $this->createOutputFolder();
            $basePath = $this->pdfFolderPathAbsolute() . '/output';
            $this->deleteOldZip($basePath);
            $zip = new ZipArchive();

            $fileOutput = $basePath . "/" . $pdfFile;
            //-----------------------------------------------------------------------------------------------
            $p = new PDFlib();
            $p->set_option("license=" . Config::get('custom.pdflib_license'));
            $p->set_option("errorpolicy=return");
            $doc = $p->begin_document($fileOutput, "destination={type=fitwindow} pagelayout=singlepage");
            if ($doc == 0) {
                throw new Exception($p->get_errmsg());
            }

            $p->set_info("Creator", "Gale Press");
            $p->set_info("Title", "Gale Press Interactive PDF");
            //-----------------------------------------------------------------------------------------------
            //open original document
            $docOriginal = $p->open_pdi_document($fileOriginal, "");
            if ($docOriginal == 0) {
                throw new Exception($p->get_errmsg());
            }

            //get page count
            $pageCount = (int)$p->pcos_get_number($docOriginal, "length:pages");

            for ($page = 0; $page < $pageCount; $page++) {
                //add new page
                $p->begin_page_ext(10, 10, "");

                //open page in original document
                $pageOriginal = $p->open_pdi_page($docOriginal, ($page + 1), "pdiusebox=crop");
                if ($pageOriginal == 0) {
                    throw new Exception($p->get_errmsg());
                }
                //$p->fit_pdi_page($pageOriginal, 0, 0, "cloneboxes");
                $p->fit_pdi_page($pageOriginal, 0, 0, "adjustpage");

                //close page in original document
                $p->close_pdi_page($pageOriginal);

                foreach ($this->ContentFilePages as $contentFilePage) {
                    if ($page + 1 == $contentFilePage->No) {
                        foreach ($contentFilePage->PageComponents as $pageComponent) {
                            $pageComponentDecorator = new PageComponentDecorator($pageComponent, $p, $this);
                            $pageComponentDecorator->createPdfComponent();
                        }
                    }
                }

                //end new page
                $p->end_page_ext("");
            }
            //close document
            $p->close_pdi_document($docOriginal);
            //-----------------------------------------------------------------------------------------------
            $p->end_document("");
            //-----------------------------------------------------------------------------------------------
            //Create zip archive
            $this->addToZip($basePath, $this->Included);

            //-----------------------------------------------------------------------------------------------
            $a = Application::find($ApplicationID);
            $a->Version = (int)$a->Version + 1;
            $a->save();

            $s = Content::find($this->ContentID);
            $s->Version = (int)$s->Version + 1;
            $s->PdfVersion = (int)$s->PdfVersion + 1;
            $s->save();

            $cf = ContentFile::find($this->ContentFileID);
            $cf->HasCreated = 1;
            $cf->InteractiveFilePath = $baseRelativePath;
            $cf->InteractiveFileName = 'file.zip';
            $cf->InteractiveFileSize = File::size($basePath . '/file.zip');
            $cf->save();
            //-----------------------------------------------------------------------------------------------
        } catch (PDFlibException $e) {
            $err = 'ApplicationID: ' . $ApplicationID . ' ContentID:' . $this->ContentID . ' ContentFileId:' . $this->ContentFileID . "\r\n";
            $err .= 'PDFlib exception occurred in starter_block sample: [' . $e->get_errnum() . '] ' . $e->get_apiname() . ': ' . $e->get_errmsg() . "\r\n";
            if (method_exists($e, 'getLine')) {
                $err .= ' Line: ' . $e->getLine();
            } else {
                $err .= ' getLine Method Not Exists';
            }
            //$err .= 'at File:' . $e->getFile() . ' at Line:' . $e->getLine();
            $cf = ContentFile::find($this->ContentFileID);
            $cf->ErrorCount = (int)$cf->ErrorCount + 1;
            $cf->LastErrorDetail = $err;
            $cf->save();
            throw new Exception($err);
        } catch (Exception $e) {
            $err = 'ApplicationID: ' . $ApplicationID . ' ContentID:' . $this->ContentID . ' ContentFileId:' . $this->ContentFileID . "\n";
            $err .= $e->getMessage();
            $err .= 'at File:' . $e->getFile() . ' at Line:' . $e->getLine();
            $cf = ContentFile::find($this->ContentFileID);
            $cf->ErrorCount = (int)$cf->ErrorCount + 1;
            $cf->LastErrorDetail = $err;
            $cf->save();
            throw new Exception($err);
        }
    }

    private function deleteOldZip($basePath) {
        if (File::exists($basePath . '/file.zip')) {
            File::delete($basePath . '/file.zip');
        }
    }

    private function addToZip($basePath, $included)
    {
        $zip = new ZipArchive();
        $res = $zip->open($basePath . '/file.zip', ZipArchive::CREATE);
        if ($res !== true) {
            return;
        }

        $arrComponentActive = array();
        $arrComponentPassive = array();

        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($basePath . "/"), RecursiveIteratorIterator::SELF_FIRST);

        foreach ($files as $file) {
            $file = str_replace('\\', '/', $file);

            //Ignore "." and ".." folders
            if (in_array(substr($file, strrpos($file, '/') + 1), array('.', '..')))
                continue;

            //Check component activity
            if (preg_match("/\/files\/customer_(\d+)\/application_(\d+)\/content_(\d+)\/file_(\d+)\/output\/comp_(\d+)/", $file, $m)) {
                //$customerID = (int)$m[1];
                //$applicationID = (int)$m[2];
                //$contentID = (int)$m[3];
                //$contentFileID = (int)$m[4];
                $checkComponentID = (int)$m[5];
                //echo $customerID.'-'.$applicationID.'-'.$contentID.'-'.$contentFileID.'-'.$checkComponentID;

                if (in_array($checkComponentID, $arrComponentPassive)) {
                    continue;
                }

                if (!in_array($checkComponentID, $arrComponentActive)) {

                    $importCount = 0;

                    if (!$included) {
                        $importCount = DB::table('PageComponentProperty')
                            ->where('PageComponentID', '=', $checkComponentID)
                            ->where('Name', '=', 'import')
                            ->where('Value', '=', 1)
                            ->where('StatusID', '=', eStatus::Active)
                            ->count();
                    }

                    $checkComponentCount = DB::table('PageComponent')
                        ->where('PageComponentID', '=', $checkComponentID)
                        ->where('StatusID', '=', eStatus::Active)
                        ->count();

                    if ($importCount == 1) {
                        //if user checked import component to pdf
                        array_push($arrComponentActive, $checkComponentID);
                    } elseif ($included && $checkComponentCount == 1) {
                        //if user said import to pdf(all components.)
                        array_push($arrComponentActive, $checkComponentID);
                    } else {
                        array_push($arrComponentPassive, $checkComponentID);
                        continue;
                    }
                }
            }

            $realFile = realpath($file);
            $relativeFile = str_replace($basePath . '/', '', $realFile);

            if (is_dir($realFile) === true) {
                $zip->addEmptyDir($relativeFile . '/');
            } else if (is_file($realFile) === true) {
                $zip->addFile($realFile, $relativeFile);
            }
        }

        $zip->close();
    }

    public function save(array $options = [])
    {
        if (isset($options['closing'])) {
            $this->Included = 1;
            $this->Interactivity = Interactivity::ProcessQueued;
            $this->HasCreated = 0;
            $this->ErrorCount = 0;
            $this->InteractiveFilePath = '';
            $this->InteractiveFileName = '';
            $this->InteractiveFileName2 = '';
            $this->InteractiveFileSize = 0;
        }

        if ($this->isClean()) {
            return true;
        }
        $userID = -1;
        if (Auth::user()) {
            $userID = Auth::user()->UserID;
        }

        if ((int)$this->ContentFileID == 0) {
            $this->DateCreated = new DateTime();
            $this->CreatorUserID = $userID;
            $this->StatusID = eStatus::Active;
            $this->ProcessTypeID = eProcessTypes::Insert;
        } else {
            $this->ProcessTypeID = eProcessTypes::Update;
        }

        $this->ProcessUserID = $userID;
        $this->ProcessDate = new DateTime();
        return parent::save();
    }

    /**
     *
     * @return string absolute folder path of the pdf
     */
    public function pdfFolderPathAbsolute()
    {
        return public_path($this->FilePath . '/file_' . $this->ContentFileID);
    }

    public function pdfFolderPathRelative()
    {
        return $this->FilePath . '/file_' . $this->ContentFileID;
    }

    public function getPdfName()
    {
        if (!empty($this->_pfdName)) {
            return $this->_pfdName;
        }
        $fileFolder = $this->pdfFolderPathAbsolute();
        $files = scandir($fileFolder);
        foreach ($files as $file) {
            if (is_file($fileFolder . '/' . $file) && Common::endsWith($file, '.pdf')) {
                $this->_pfdName = $file;
                break;
            }
        }
        return $this->_pfdName;
    }

    public function createPdfSnapShots()
    {
        $pdfAbsolutePath = $this->pdfFolderPathAbsolute() . '/' . $this->getPdfName();
        $gsCommand = array();
        $gsCommand[] = 'gs';
        $gsCommand[] = '-o \'' . $this->pdfFolderPathAbsolute() . '/' . File::name($pdfAbsolutePath) . '_%d.jpg\'';
        $gsCommand[] = '-sDEVICE=jpeg';
        $gsCommand[] = '-dUseCrop\Box';
        $gsCommand[] = '-dJPEGQ=100';
        $gsCommand[] = '-r72x72';
        $gsCommand[] = "'" . $pdfAbsolutePath . "'";
        shell_exec(implode(" ", $gsCommand));
    }


    public function comparePages()
    {
        // Eski pdfin interactif ogelerini yeni pdfe aktar secili ise...
        if (!$this->Transferred) {
            return;
        }
        $oldContentFile = $this->oldContentFile();
        if (!$oldContentFile) {
            return;
        }
        if (!$this->ContentFilePages) {
            return;
        }


        $matches = array();
        for ($i = 0; $i < count($oldContentFile->ContentFilePages); $i++) {
            $matches[$i] = -1;
            try {
                $oldContentFilePage = $oldContentFile->ContentFilePages[$i];
                if (count($oldContentFilePage->PageComponent) == 0) {
                    continue;
                }
                $oldPage = new Imagick(public_path($oldContentFilePage->FilePath . '/' . $oldContentFilePage->FileName));
                for ($j = 0; $j < count($this->ContentFilePages); $j++) {
                    try {
                        $newContentFilePage = $this->ContentFilePages[$i];
                        $newPagePath = $this->pdfFolderPathAbsolute() . "/" . $newContentFilePage->FileName;
                        $newPage = new Imagick($newPagePath);
                        $result = $newPage->compareImages($oldPage, Imagick::METRIC_MEANSQUAREERROR);
                        if (!isset($result)) {
                            continue;
                        }
                        $newPage->clear();
                        $newPage->destroy();
                        $similarity = 1 - (float)$result[1];
                        if ($similarity > 0.7 && !in_array($j, $matches)) {
                            //1- ilk buldugun sayfayla match et...
                            //2- eski sayfanin componentlerini yeni sayfasina tasi
                            //3- eski sayfanin componentinlerinin fiziksel dosyalarini yeni sayfasina tasi.
                            $matches[$i] = $j;
                            foreach ($oldContentFilePage->PageComponents as $pageComponent) {
                                $pageComponent->ContentFilePageID = $newContentFilePage->ContentFilePageID;
                                $pageComponent->save();
                                foreach ($pageComponent->PageComponentProperty as $pageComponentProperty) {
                                    // /file_ID/ varsa icinde degistir...
                                    $pageComponentProperty->Value = str_replace('/file_' . $oldContentFile->ContentFileID . '/', '/file_' . $this->ContentFileID . '/', $pageComponentProperty->Value);
                                    $pageComponentProperty->save();
                                }
                                $pageComponent->moveToNewContentFile($this, $oldContentFile);

                            }


                            break;
                        }
                    } catch (Exception $e) {
                        if (isset($newPage)) {
                            $newPage->clear();
                            $newPage->destroy();
                        }
                    }
                }
            } catch (Exception $e) {
                if (isset($oldPage)) {
                    $oldPage->clear();
                    $oldPage->destroy();
                }
            }
        }
    }

    /**
     * @return ContentFile
     */
    public function oldContentFile()
    {
        return ContentFile::where('ContentFileID', '<', $this->ContentFileID)
            ->where('ContentID', '=', $this->ContentID)
            ->where('Interactivity', '=', 1)
            ->where('StatusID', '=', eStatus::Active)
            ->orderBy('ContentFileID', 'DESC')
            ->first();
    }

    public function pdfOriginalLink()
    {
        return '/' . $this->pdfFolderPathRelative() . '/file.pdf';
    }

    public function Pages($statusID = eStatus::Active)
    {
        return $this->hasMany(ContentFilePage::class , self::$key)->getQuery()->where('StatusID', '=', $statusID)->get();
    }

    public function ActivePages()
    {
        return $this->hasMany(ContentFilePage::class, self::$key)->getQuery()->where('StatusID', '=', eStatus::Active)->get();
    }

    public function ActiveCoverImageFile()
    {
        return $this->ContentCoverImageFile()->where('StatusID', '=', eStatus::Active)->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ContentCoverImageFile() {
        return $this->hasMany(ContentCoverImageFile::class, self::$key);
    }

    public function ContentFilePages()
    {
        return $this->hasMany(ContentFilePage::class, self::$key);
    }


}
