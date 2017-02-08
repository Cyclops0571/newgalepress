<?php

class Category {
    public $parent;
    public $name;
    /**
     * @var Category[]
     */
    public $children = [];
    function __construct($name, $parent)
    {
        $this->name = $name;
        if($parent == null) {
            $this->parent == null;
        } else {
            $parent->children[] = $this;
            $this->parent = $parent->name;
        }
    }

    public function isInTheTree($name) {
        if($this->getCategory($name)) {
            return true;
        }
        return false;
    }

    public function getCategory($name) {
        if($this->name == $name) {
            return $this;
        } else {
            foreach ($this->children as $childCategory) {
                $category = $childCategory->getCategory($name);
                if($category instanceof Category) {
                    return $category;
                }
            }
        }
        return null;
    }


    private function getNames() {
        $result = [];
        $result[] = $this->name;
        foreach ($this->children as $child) {
            $result[] = $child->getNames();
        }
        return $result;
    }

    public function getChildrenNames() {
        $result = [];
        foreach ($this->children as $child) {
            $result = array_merge($result, $child->getNames());
        }
        return $result;
    }
}


class CategoryTree
{
    /**
     * @var Category[]
     */
    public $rootCategories = [];
    public function addCategory($categoryName, $parentName)
    {
        foreach($this->rootCategories as $rootCategory) {
            if($rootCategory->isInTheTree($categoryName)) {
                throw new InvalidArgumentException();
            }
        }

        if($parentName == null) {
            $this->rootCategories[] = new Category($categoryName, null);
            return;
        } else {
            foreach ($this->rootCategories as $rootCategory) {
                $parent = $rootCategory->getCategory($parentName);
                if ($parent instanceof Category) {
                    new Category($categoryName, $parent);
                    return;
                }
            }
        }
        throw new InvalidArgumentException();
    }

    public function getChildren($parent)
    {
        foreach($this->rootCategories as $rootCategory) {
            $parentCategory = $rootCategory->getCategory($parent);
            if($parentCategory instanceof  Category) {
                return $parentCategory->getChildrenNames();
            }
        }
        throw new InvalidArgumentException();
    }
}

$c = new CategoryTree;
$c->addCategory('A', null);
$c->addCategory('B', 'A');
$c->addCategory('C', 'A');
echo implode(',', $c->getChildren('A'));


//$input_string = "Last time it rained was on 07/25/2013 and today is 08/09/2013.";
//echo preg_replace("~(\d{2})\/(\d{2})\/(\d{4})~", '${2}/${1}/${3}', $input_string);
//
//class ProgrammerTeacher extends Programmer
//{
//    private function isKnown($language)
//    {
//        $language = trim((string)$language);
//        if(in_array($language, $this->getLanguages())) {
//            return true;
//        }
//        return false;
//    }
//
//    public function teach (Programmer $programmer, $language) {
//        if($this->isKnown($language)) {
//            $programmer->addLanguage($language);
//            return true;
//        }
//        return false;
//    }
//}
//
//class Programmer
//{
//    private $languages = [];
//
//    public function addLanguage($language)
//    {
//        $language = trim((string)$language);
//        if (!empty($language) && !in_array($language, $this->languages)) {
//            $this->languages[] = $language;
//        }
//    }
//
//    public function getLanguages()
//    {
//        return $this->languages;
//    }
//}
