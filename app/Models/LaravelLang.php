<?php

namespace App\Models;

use DB;
use File;
use Illuminate\Database\Eloquent\Model;
use Lang;

/**
 * App\Models\LaravelLang
 *
 * @property int $LaravelLangID
 * @property string $de
 * @property string $en
 * @property string $tr
 * @property string $usa
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LaravelLang whereDe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LaravelLang whereEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LaravelLang whereLaravelLangID($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LaravelLang whereTr($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\LaravelLang whereUsa($value)
 * @mixin \Eloquent
 */
class LaravelLang extends Model
{


    public $timestamps = false;
    protected $table = 'LaravelLang';
    protected $primaryKey = 'LaravelLangID';
    public static $exportFolder = 'exportedlangs/';
    public static $langFiles = array(
        'clients',
        'common',
        'content',
        'error',
        'interactivity',
        'javascriptlang',
        'notification',
        'pagination',
        'route',
        'validation',
        'website',
    );
    public static $langs = array(
        'en', 'tr', 'de', 'usa'
    );

    /**
     * Imports Laravel Language Files To DB
     */
    public static function import()
    {
        foreach (self::$langFiles as $langFile) {
            foreach (self::$langs as $lang) {
                $translationFile = trans($langFile, [], 'messages', $lang);
                foreach ($translationFile as $key => $value) {
                    $translationKey = $langFile . "." . $key;
                    if(!($laravelLang = LaravelLang::where('LaravelLangID', $translationKey)->first())) {
                        $laravelLang = new LaravelLang();
                        $laravelLang->LaravelLangID = $translationKey;
                    }
                    $laravelLang->$lang = json_encode(Lang::get($langFile . "." . $key, [], $lang));
                    $laravelLang->save();
                }
            }
        }
    }

    private static function _arrayStringfy($subject)
    {
        if (is_array($subject)) {
            $result = 'array(';
            if ((bool)count(array_filter(array_keys($subject), 'is_string'))) {
                //associative array
                foreach ($subject as $key => $value) {
                    $result .= "\n\t\t'" . $key . "' => " . DB::connection()->getPdo()->quote($value) . ",";
                }
                $result .= "\n\t)";

            } else {
                foreach ($subject as $value) {
                    $result .= DB::connection()->getPdo()->quote($value) . ',';
                }
                $result .= ")";
            }

        } else {
            $result = DB::connection()->getPdo()->quote($subject);
        }
        return $result;
    }

    /**
     * Exports|Creates Laravel Language Files From Database
     */
    public static function export()
    {
        set_time_limit(0);
        $starter = "<?php \n return array(";
        $ender = "\n);";
        File::cleanDirectory(public_path(self::$exportFolder));
        foreach (self::$langs as $lang) {
            File::makeDirectory(public_path(self::$exportFolder . $lang));
            foreach (self::$langFiles as $langFile) {
                File::put(public_path(self::$exportFolder . $lang . "/" . $langFile . ".php"), $starter);

            }
        }

        /** @var LaravelLang[] $laravelLangs */
        $laravelLangs = LaravelLang::get();
        foreach ($laravelLangs as $laravelLang) {
            $exp = explode('.', $laravelLang->LaravelLangID);

            $fileName = $exp[0] . ".php";
            $key = $exp[1];

            foreach (self::$langs as $lang) {
                $filePath = public_path(self::$exportFolder . $lang . "/" . $fileName);
                $laravelLang->addComment($filePath);
                $value = empty($laravelLang->$lang) ? "\t'',\n" : "\t'" . $key . "' => " . json_decode($laravelLang->$lang) . ",\n";
                File::append($filePath, $value);
            }
        }

        foreach (self::$langs as $lang) {
            foreach (self::$langFiles as $langFile) {
                File::append(public_path(self::$exportFolder . $lang . "/" . $langFile . ".php"), $ender);

            }
        }
    }

    private function addComment($filePath)
    {
        switch ($this->LaravelLangID) {
            case 'validation.custom':
                $comment = <<<EOF

    /*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

EOF;

                File::append($filePath, $comment);
                break;
            case 'validation.attributes':
                $comment = <<<EOF

    /*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

EOF;
                File::append($filePath, $comment);
                break;
        }
    }

}
