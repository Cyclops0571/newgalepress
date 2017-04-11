<?php


namespace App\Library;

use App\Models\Component;
use App\Models\ContentFile;
use App\Models\PageComponent;
use Exception;
use File;
use PDFlib;
use ZipArchive;

/**
 * Class PageComponentDecorator
 * @package App\Library
 * @property int trigger_x
 * @property int trigger_y
 * @property int x
 * @property int y
 * @property int w
 * @property int h
 * @property int propertyImport
 * @property int propertyModal
 * @property int propertyType
 * @property string propertyUrl
 * @property string propertyMail
 * @property int propertyPage
 * @property string propertyText
 * @property string propertyLat
 * @property string propertyLon
 * @property float propertyZoom
 * @property int trigger_w
 * @property int trigger_h
 * @property array data
 * @property string qs
 */
class PageComponentDecorator {

    /** @var  PageComponent $pageComponent */
    private $pageComponent;

    /** @var PDFlib $pdfLib */
    private $pdfLib;
    /** @var ContentFile $contentFile */
    private $contentFile;

    private $data = [];

    const LINK_PAGE = 1;
    const LINK_HTML = 2;
    const LINK_MAIL = 3;


    public function __construct(PageComponent $pc, PDFlib $pdfLib, ContentFile $contentFile)
    {
        $this->pageComponent = $pc;
        $this->pdfLib = $pdfLib;
        $this->contentFile = $contentFile;
        $this->data = [
            'preview'       => false,
            'baseDirectory' => '',
            'id'            => $this->pageComponent->PageComponentID,
        ];
        $this->mapMyProperties();
    }

    public function createPdfComponent()
    {
        if ($this->propertyModal == 1)
        {
            $image_url = public_path($this->data["modaliconname"]);
            if (File::exists($image_url) && is_file($image_url))
            {
                $image_url = config("custom.url") . "/" . $this->data["modaliconname"];
            } else
            {
                $image_url = url("/files/components/" . $this->pageComponent->Component->Class . "/icon.png");
            }
            $imageData = file_get_contents($image_url);
            if ($imageData == false)
            {
                throw new Exception("Error: file_get_contents($image_url) failed");
            }
            $this->pdfLib->create_pvf("/pvf/image", $imageData, "");
            $triggerImage = $this->pdfLib->load_image("auto", "/pvf/image", "");

            if ($triggerImage == 0)
            {
                throw new Exception($this->pdfLib->get_errmsg());
            }

            $optionList = "boxsize={" . $this->w . " " . $this->h . "} position={center} fitmethod=meet";
            $this->pdfLib->fit_image($triggerImage, $this->x, $this->y, $optionList);
            $this->pdfLib->close_image($triggerImage);
            $this->pdfLib->delete_pvf("/pvf/image");
        }


        switch ($this->pageComponent->ComponentID)
        {
            case Component::ComponentAnimation:
            case Component::ComponentTooltip:
            case Component::ComponentScroller:
            case Component::ComponentSlideShow:
            case Component::Component360:
                $this->createDefaultComponent();
                break;
            case Component::ComponentVideo:
                $this->createVideo();
                break;
            case Component::ComponentAudio:
                $this->createAudio();
                break;
            case Component::ComponentMap:
                $this->createMap();
                break;
            case Component::ComponentLink:
                $this->createLink();
                break;
            case Component::ComponentWeb:
                $this->createWeb();
                break;
            case Component::ComponentBookmark:
                $this->createBookmark();
                break;
        }

    }

    private function createDefaultComponent()
    {
        $outputPath = $this->contentFile->pdfFolderPathAbsolute() . '/output';
        $this->createComponentFolder();
        $this->copyComponentZipFiles();
        $content = view('interactivity.components.' . $this->pageComponent->Component->Class . '.dynamic', $this->data)->render();
        File::put($outputPath . '/comp_' . $this->pageComponent->PageComponentID . '.html', $content);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->getUrl() . "}");
        $this->pdfLib->create_annotation(
            $this->x,
            $this->y,
            $this->x + $this->w,
            $this->y + $this->h,
            "Link",
            "linewidth=0 action {activate $action}"
        );
    }

    private function createVideo()
    {

        //video url youtube embed
        if (!(strpos($this->propertyUrl, 'www.youtube.com/embed') === false))
        {

            if (strpos($this->propertyUrl, '?') !== false)
            {
                $this->qs = str_replace('?', '&', $this->qs);
            }
            $this->propertyUrl = str_replace("http", "ylweb", $this->propertyUrl . $this->qs);
            $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyUrl . "}");
            $this->pdfLib->create_annotation(
                $this->x,
                $this->y,
                $this->x + $this->w,
                $this->y + $this->h,
                "Link", "linewidth=0 action {activate $action}"
            );
        } else
        {
            $this->createDefaultComponent();
        }
    }

    private function createAudio()
    {
        $this->x = $this->trigger_x;
        $this->y = $this->trigger_y - $this->trigger_h;
        $this->w = $this->trigger_w;
        $this->h = $this->trigger_h;

        $this->createDefaultComponent();
    }

    private function createMap()
    {
        $mapType = 'standard';

        if ($this->propertyType == 2)
        {
            $mapType = 'hybrid';
        } else if ($this->propertyType == 3)
        {
            $mapType = 'satellite';
        }
        $zoom = ((100 - ($this->propertyZoom * 1000)) / 1000);
        $propertyUrl = 'ylmap://' . $mapType . $this->qs
            . '&lat=' . $this->propertyLat . '&lon=' . $this->propertyLon . '&slat=' . $zoom . '&slon=' . $zoom;
        $action = $this->pdfLib->create_action("URI", "url {" . $propertyUrl . "}");
        $this->pdfLib->create_annotation(
            $this->x,
            $this->y,
            $this->x + $this->w,
            $this->y + $this->h,
            "Link",
            "linewidth=0 action {activate $action}");
    }

    private function createLink()
    {
        switch ($this->propertyType)
        {
            case self::LINK_HTML:
                if (strpos($this->propertyUrl, '?') !== false)
                {
                    $this->qs = str_replace('?', '&', $this->qs);
                }
                $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyUrl . $this->qs . "}");
                break;
            case self::LINK_MAIL:
                $this->propertyMail = "mailto:" . $this->propertyMail;
                $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyMail . "}");
                break;
            case self::LINK_PAGE:
            default:
                $optionList = "destination={page=" . $this->propertyPage . " type=fixed left=10 top=10 zoom=1}";
                $action = $this->pdfLib->create_action("GOTO", $optionList);
        }
        $this->pdfLib->create_annotation(
            $this->x,
            $this->y,
            $this->x + $this->w,
            $this->y + $this->h,
            "Link",
            "linewidth=0 action {activate $action}");
    }

    private function createWeb()
    {
        if (strpos($this->propertyUrl, '?') !== false)
        {
            $this->qs = str_replace('?', '&', $this->qs);
        }
        $this->propertyUrl = str_replace("http", "ylweb", $this->propertyUrl . $this->qs);
        $action = $this->pdfLib->create_action("URI", "url {" . $this->propertyUrl . "}");
        $this->pdfLib->create_annotation(
            $this->x,
            $this->y,
            $this->x + $this->w,
            $this->y + $this->h,
            "Link",
            "linewidth=0 action {activate $action}");
    }

    private function createBookmark()
    {
        $this->propertyText = pack('H*', 'feff') . mb_convert_encoding($this->propertyText, 'UTF-16', 'UTF-8');
        $this->trigger_x = $this->trigger_x > 0 ? $this->trigger_x : 0;
        $this->trigger_y = $this->trigger_y > 0 ? $this->trigger_y : 0;
        $destination = "destination={page=%s type=fixed left=%s top=%s zoom=1}";
        $parameters[] = $this->pageComponent->ContentFilePage->No;
        $parameters[] = $this->trigger_x;
        $parameters[] = $this->trigger_y;
        $this->pdfLib->create_bookmark($this->propertyText, vsprintf($destination, $parameters));
    }

    private function getPath()
    {
        return $this->getOutputPath() . '/comp_' . $this->pageComponent->PageComponentID;

    }

    private function getOutputPath()
    {
        return $this->contentFile->pdfFolderPathAbsolute() . '/output';
    }

    private function createComponentFolder()
    {

        if (!File::exists($this->getPath()))
        {
            File::makeDirectory($this->getPath());
        }
    }

    public function copyComponentZipFiles()
    {
        $componentZipPath = $this->getOutputPath() . '/' . mb_strtolower($this->pageComponent->Component->Class);
        if (File::exists($componentZipPath))
        {
            if (!is_file($componentZipPath))
            {
                File::deleteDirectory($componentZipPath);
            } else
            {
                File::delete($componentZipPath);
            }
        }
        File::deleteDirectory($componentZipPath);

        //extract zip file
        $zipFile = $this->pageComponent->Component->getZipPath();
        $zip = new ZipArchive();
        $res = $zip->open($zipFile);
        if ($res === true)
        {
            $zip->extractTo($componentZipPath);
            $zip->close();
        }
    }

    private function getUrl()
    {
        if ($this->contentFile->Included == 1 || $this->propertyImport == 1)
        {
            return 'ylweb://localhost/comp_' . $this->pageComponent->PageComponentID . '.html' . $this->qs;
        }

        $link = [];
        $link[] = 'ylweb://www.galepress.com/files';
        $link[] = 'customer_' . $this->contentFile->Content->Application->CustomerID;
        $link[] = 'application_' . $this->contentFile->Content->ApplicationID;
        $link[] = 'content_' . $this->contentFile->ContentID;
        $link[] = 'file_' . $this->contentFile->ContentFileID;
        $link[] = 'output/comp_' . $this->pageComponent->PageComponentID . '.html' . $this->qs;

        return implode('/', $link);
    }

    private function mapMyProperties()
    {

        $files = [];
        $this->trigger_x = 0;
        $this->trigger_y = 0;
        $this->trigger_w = 60;
        $this->trigger_h = 60;
        $this->x = 60;
        $this->y = 0;
        $this->w = 0;
        $this->h = 0;
        $this->propertyImport = 0;
        $this->propertyModal = 0;
        $this->propertyType = 0;
        $this->propertyUrl = '';
        $this->propertyMail = '';
        $this->propertyPage = 0;
        $this->propertyText = '';
        $this->propertyLat = '';
        $this->propertyLon = '';
        $this->propertyZoom = 0.09;

        foreach ($this->pageComponent->PageComponentProperty as $cp)
        {
            switch ($cp->Name)
            {
                case 'trigger-x':
                    $this->trigger_x = (int)$cp->Value;
                    break;
                case 'trigger-y':
                    $this->trigger_y = (int)$cp->Value;
                    break;
                case 'x':
                    $this->x = (int)$cp->Value;
                    break;
                case 'y':
                    $this->y = (int)$cp->Value;
                    break;
                case 'w':
                    $this->w = (int)$cp->Value;
                    break;
                case 'h':
                    $this->h = (int)$cp->Value;
                    break;
                case 'import':
                    $this->propertyImport = (int)$cp->Value;
                    break;
                case 'modal':
                    $this->propertyModal = (int)$cp->Value;
                    break;
                case 'type':
                    $this->propertyType = (int)$cp->Value;
                    break;
                case 'url':
                    $this->propertyUrl = $cp->Value;
                    break;
                case 'mail':
                    $this->propertyMail = $cp->Value;
                    break;
                case 'page':
                    $this->propertyPage = (int)$cp->Value;
                    break;
                case 'text':
                    $this->propertyText = $cp->Value;
                    break;
                case 'lat':
                    $this->propertyLat = $cp->Value;
                    break;
                case 'lon':
                    $this->propertyLon = $cp->Value;
                    break;
                case 'zoom':
                    $this->propertyZoom = (float)$cp->Value;
                    break;
                case 'filename':
                    $files[] = $cp->Value;
                    break;
            }
            $this->data = array_merge($this->data, [$cp->Name => $cp->Value]);
        }

        if ($this->propertyModal == 1)
        {
            $this->trigger_w = 52;
            $this->trigger_h = 52;
        }
        $this->data = array_merge($this->data, ['files' => $files]);

        //reverse y
        $this->y = $this->pageComponent->ContentFilePage->Height - $this->y - $this->h;
        $this->trigger_y = $this->pageComponent->ContentFilePage->Height - $this->trigger_y;

        $paramQS = [];
        $paramQS[] = 'componentTypeID=' . $this->pageComponent->ComponentID;
        $paramQS[] = 'modal=' . $this->propertyModal;
        $this->qs = '?' . implode("&", $paramQS);
    }

}