<?php


namespace App\Library;


use App\Models\PageComponent;
use App\Models\PageComponentProperty;
use Config;
use eStatus;
use Exception;
use File;

class MyPcos
{
    const colorspaces = "colorspaces";
    const extgstates = "extgstates";
    const fonts = "fonts";
    const images = "images";
    const patterns = "patterns";
    const properties = "properties";
    const shadings = "shadings";
    const templates = "templates";

    private $annotationProperties = array("destpage", "Subtype", "A/URI", "Rect[0]", "Rect[1]", "Rect[2]", "Rect[3]");
    private $document = null;
    private $pdfPath;
    /** @var null|PDFlib */
    private $pdfLib = null;
    private $pcosmode = null;
    private $plainMetaData = null;
    private $encryptNoCopy = null;
    private $pdfversion = null;
    private $pageCount = 0;
    private $pageDimensions = array();
    private $fontProperties = array();
    private $imageProperties = array();
    private $bookmarks = null;
    private $annotations = array();
    private $bookmarksArranged = false;

    public function __construct($pdfPath)
    {
        $this->pdfPath = $pdfPath;
        $this->pdfLib = new PDFlib();
        $this->pdfLib->set_option("license=" . Config::get('custom.pdflib_license'));
        $this->pdfLib->set_option("errorpolicy=return");
        $this->document = $this->pdfLib->open_pdi_document($this->pdfPath, "");
        if ($this->document == 0) {
            throw new Exception($this->pdfLib->get_errmsg());
        }

        $this->pcosmode = $this->pdfLib->pcos_get_number($this->document, "pcosmode");
        if ($this->pcosmode == 0) {
            throw new Exception("Encripted document");
        }

        $this->plainMetaData = (int)$this->pdfLib->pcos_get_number($this->document, "encrypt/plainmetadata");
        $this->encryptNoCopy = (int)$this->pdfLib->pcos_get_number($this->document, "encrypt/nocopy");

        if ($this->pcosmode == 1 && !$this->plainMetaData && $this->encryptNoCopy != 0) {
            throw new Exception("Resctricted Access");
        }

        $this->pdfversion = $this->pdfLib->pcos_get_number($this->document, "fullpdfversion");
        $this->pageCount = (int)$this->pdfLib->pcos_get_number($this->document, "length:pages");

        for ($i = 0; $i < $this->pageCount; $i++) {
            $height = $this->pdfLib->pcos_get_number($this->document, "pages[" . $i . "]/height");
            $width = $this->pdfLib->pcos_get_number($this->document, "pages[" . $i . "]/width");
            $this->pageDimensions[$i] = array("width" => $width, "height" => $height);
        }

    }

    public function arrangeBookmarkNew($cfp)
    {
        if ($this->bookmarksArranged) {
            return;
        }

        $this->bookmarksArranged = true;
        //added by hknsrr, weblink, pagelink ve bookmark annotation içeren
        //pdf'lerin sisteme yüklendikleri zaman bu annotationların sisteme kaydedilerek interaktif tasarlayıcıda gösterilmesi.
        $bookmarks = $this->getBookmarks();
        for ($i = 0; $i < count($bookmarks); $i++) {
            $bookmarkDestpage = $bookmarks[$i]["destpage"];
            $bookmarkTitle = $bookmarks[$i]["Title"];
            $lastComponentNo = PageComponent::where('ContentFilePageID', $cfp->ContentFilePageID + $bookmarkDestpage - 1)->max('No');

            $linkAnnotPageComponent = new PageComponent();
            //burada sorun var
            $linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID + $bookmarkDestpage - 1;
            $linkAnnotPageComponent->ComponentID = 10;
            $linkAnnotPageComponent->No = $lastComponentNo + 1;
            $linkAnnotPageComponent->save();

            //Bookmark Component
            $pageCompenentProperties = array(
                "pcid" => "0",
                "text" => $bookmarkTitle,
                "trigger-x" => 10,
                "trigger-y" => 10
            );
            PageComponentProperty::batchInsert($linkAnnotPageComponent->PageComponentID, $pageCompenentProperties);

        }
    }

    public function getBookmarks()
    {
        if ($this->bookmarks == null) {
            $this->bookmarks = array();
            $properties = array("destpage", "Title");
            $bookmarkCount = (int)$this->pdfLib->pcos_get_number($this->document, "length:bookmarks");
            for ($i = 0; $i < $bookmarkCount; $i++) {
                $tmp = array();
                for ($j = 0; $j < count($properties); $j++) {
                    $tmp[$properties[$j]] = $this->readProperty("bookmarks[" . $i . "]/" . $properties[$j]);
                }
                $this->bookmarks[$i] = $tmp;
            }

        }
        return $this->bookmarks;
    }

    public function arrangeAnnotationNew($cfp, $pageNo)
    {
        //added by hknsrr, weblink, pagelink ve bookmark annotation içeren
        //pdf'lerin sisteme yüklendikleri zaman bu annotationların sisteme kaydedilerek interaktif tasarlayıcıda gösterilmesi.

        $annotations = $this->getAnnotations($pageNo);
        $height = $this->height($pageNo);
        $width = $this->width($pageNo);

        for ($i = 0; $i < count($annotations); $i++) {
            $linkDest = $annotations[$i]["destpage"];
            $subtype = $annotations[$i]["Subtype"];
            $uri = $annotations[$i]["A/URI"];
            // "Rect[0]", "Rect[1]", "Rect[2]", "Rect[3]"
            //loverleftx loverlefty upperrightx upperrighty
            $llx = $annotations[$i]["Rect[0]"] < 0 ? 0 : $annotations[$i]["Rect[0]"];
            $lly = $annotations[$i]["Rect[1]"] < 0 ? 0 : $annotations[$i]["Rect[1]"];
            $urx = $annotations[$i]["Rect[2]"] > $width ? $width : $annotations[$i]["Rect[2]"];
            $ury = $annotations[$i]["Rect[3]"] > $height ? $height : $annotations[$i]["Rect[3]"];
            if ($llx >= $width || $lly >= $height || $urx <= 0 || $ury <= 0) {
                continue; //bu durumda sacma bir component var demektir bu komponenti koymuyorum pdfe
            }

            $rectWidth = $urx - $llx;
            $rectHeight = $ury - $lly;
            if ($rectWidth < 0 || $rectHeight < 0) {
                continue;
            }

            $lastComponentNo = (int)PageComponent::where('ContentFilePageID', '=', $cfp->ContentFilePageID)->max('No');


            //Web Link
            if ($linkDest == -1 || $subtype != "Link") {
                //baska bir pdf dokümanina link veriyor bunu gecelim
                //link olmayan annotationlari geciyorum.
                continue;
            }

            if ($subtype == "Link" && substr($uri, 0, 2) != "yl") {

                //Weblink Component
                $componentProperties = array(
                    "pcid" => "0",
                    "type" => "2",
                    "page" => $cfp->No,
                    "url" => $uri,
                    "x" => $llx,
                    "y" => $lly,
                    "w" => $rectWidth,
                    "h" => $rectHeight,
                );
            } else {
                //Weblink Component
                $componentProperties = array(
                    "pcid" => "0",
                    "type" => "1",
                    "page" => $linkDest,
                    "url" => "http://",
                    "x" => $llx,
                    "y" => $lly,
                    "w" => $rectWidth,
                    "h" => $rectHeight,
                );
            }
            //Page Link
            $linkAnnotPageComponent = new PageComponent();
            $linkAnnotPageComponent->ContentFilePageID = $cfp->ContentFilePageID;
            $linkAnnotPageComponent->ComponentID = 4;
            $linkAnnotPageComponent->No = $lastComponentNo + 1;
            $linkAnnotPageComponent->save();
            PageComponentProperty::batchInsert($linkAnnotPageComponent->PageComponentID, $componentProperties);

        }
    }

    public function getAnnotations($page)
    {
        if ($page < 0 || $page >= $this->pageCount) {
            throw new Exception("Page overflow occured");
        }
        if (!isset($this->annotations[$page])) {
            $this->annotations[$page] = array();

            $annotationsPath = "pages[" . $page . "]/annots";

            $anncount = (int)$this->pdfLib->pcos_get_number($this->document, "length:" . $annotationsPath);
            if ($anncount > 0) {
                $counter = min(array($anncount, 30)); //30dan fazla interactif öğe sayfada olmasın.
                for ($i = 0; $i < $counter; $i++) {
                    $currentPath = $annotationsPath . "[" . $i . "]/";
                    for ($j = 0; $j < count($this->annotationProperties); $j++) {
                        $this->annotations[$page][$i][$this->annotationProperties[$j]] = $this->readProperty($currentPath . $this->annotationProperties[$j]);
                    }
                }
            }
        }

        return $this->annotations[$page];
    }

    public function height($page)
    {
        if ($page < 0 || $page >= $this->pageCount) {
            throw new Exception("Page overflow occured");
        }
        return $this->pageDimensions[$page]["height"];
    }

    public function width($page)
    {
        if ($page < 0 || $page >= $this->pageCount) {
            throw new Exception("Page overflow occured");
        }
        return $this->pageDimensions[$page]["width"];
    }

    public function checkPageSnapshots()
    {
        for ($i = 0; $i < $this->pageCount(); $i++) {
            $imageFile = dirname($this->pdfPath) . "/" . File::name($this->pdfPath) . '_' . ($i + 1) . '.jpg';
            if (!File::exists($imageFile)) {
                throw new Exception("File does not exits: " . $imageFile);
            }
        }
    }

    public function pageCount()
    {
        return $this->pageCount;
    }

    public function getImageFileName($pageNo)
    {
        $pageNo = (int)$pageNo;
        if ($pageNo < 0 || $pageNo > $this->pageCount()) {
            throw new Exception("Invalid Page No");
        }

        return File::name($this->pdfPath) . '_' . ($pageNo + 1) . '.jpg';
    }

    public function closePdf()
    {
        $this->pdfLib->close_pdi_document($this->document);
    }

    private function readFontProperties()
    {
        $fontCount = $this->pdfLib->pcos_get_number($this->document, "length:fonts");
        for ($i = 0; $i < $fontCount; $i++) {
            $tmpArray = array(
                "fontName" => $this->readProperty("fonts[" . $i . "]/name"),
                "embedded" => $this->readProperty("fonts[" . $i . "]/embedded"),
                "vertical" => $this->readProperty("fonts[" . $i . "]/vertical"),
                "ascender" => $this->readProperty("fonts[" . $i . "]/ascender"),
                "descender" => $this->readProperty("fonts[" . $i . "]/descender"),
            );
            $this->fontProperties[] = $tmpArray;
        }
    }

    private function readProperty($property)
    {
        $propertyType = $this->readType($property);
        switch ($propertyType) {
            case 'null': //null object or object does not exits
                return null;
                break;
            case 'boolean': //booean object
                return (boolean)$this->pdfLib->pcos_get_number($this->document, $property);
                break;
            case 'number': //integer or real number
                return $this->pdfLib->pcos_get_number($this->document, $property);
                break;
            case 'name': //name object
                return $this->pdfLib->pcos_get_string($this->document, $property);
                break;
            case 'string': //string object
                return $this->pdfLib->pcos_get_string($this->document, $property);
                break;
            case 'array': //array object
                return $this->pdfLib->pcos_get_string($this->document, $property);
                break;
            case 'dict': //dictionary object (but not stream)
                return $this->pdfLib->pcos_get_string($this->document, $property);
                break;
            case 'stream': //stream object which uses only supported filters
                return $this->pdfLib->pcos_get_string($this->document, $property);
                break;
            case 'fstream': //stream object which uses one ore more unsupported filters
                return $this->pdfLib->pcos_get_string($this->document, $property);
                break;
            default:
                throw new Exception('Unknown pdftype: ' . $propertyType);
        }
    }

    private function readType($property)
    {
        return $this->pdfLib->pcos_get_string($this->document, "type:" . $property);
    }

    private function readImageProperties()
    {
        $fontCount = $this->pdfLib->pcos_get_number($this->document, "length:fonts");
        for ($i = 0; $i < $fontCount; $i++) {
            $tmpArray = array(
                "Height" => $this->readProperty("fonts[" . $i . "]/Height"),
                "Width" => $this->readProperty("fonts[" . $i . "]/Width"),
                "bpc" => $this->readProperty("fonts[" . $i . "]/bpc"),

            );
            $this->imageProperties[] = $tmpArray;
        }
    }


}