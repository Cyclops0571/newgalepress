<?php 

/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Language
 * @version  3.2.3
 * @author   Sinan Eldem <sinan@sinaneldem.com.tr>
 * @link     http://sinaneldem.com.tr
 */

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/

	"accepted"       => ":attribute muss angenommen werden.",
	"active_url"     => ":attribute muss eine gültige URL sein. ",
	"after"          => ":attribute muss später sein als :date.",
	"alpha"          => ":attribute muss nur aus Buchstaben bestehen. ",
	"alpha_dash"     => ":attribute muss nur aus Buchstaben, Zahlen und Bindestrichen bestehen.",
	"alpha_num"      => ":attribute muss nur Buchstaben und Zahlen beinhalten.",
	"before"         => ":attribute muss früher sein als :date.",
	"between"        => array(
		"numeric" => ":attribute muss zwischen :min - :max liegen.",
		"file"    => ":attribute muss einen Kilobyte-Wert zwischen :min - :max aufweisen.",
		"string"  => ":attribute  muss aus :min - :max  zeichen bestehen.",
	),
	"confirmed"      => ":attribute bestätigung stimt nicht überein. ",
	"different"      => ":attribute und :other dürfen nicht identisch sein. ",
	"email"          => ":attribute format ist ungültig. ",
	"exists"         => ":attribute wahl ist ungültig.",
	"image"          => ":attribute muss eine Bilddatei sein.",
	"in"             => ":attribute Wahl ungültig.",
	"integer"        => ":attribute muss eine Zahl sein.",
	"ip"             => ":attribute muss eine gültige IP-Adresse sein.",
	"match"          => ":attribute format ist ungültig.",
	"max"            => array(
		"numeric" => ":attribute muss kleiner sein als :max.",
		"file"    => ":attribute muss kleiner sein als :max kilobyte.",
		"string"  => ":attribute muss kleiner sein als :max zeichen.",
	),
	"mimes"          => ":attribute dateiformat muss :values sein.",
	"min"            => array(
		"numeric" => ":attribute muss mindestens :min sein.",
		"file"    => ":attribute muss mindestens :min kilobyte sein.",
		"string"  => ":attribute muss mindestens :min zeichen sein.",
	),
	"not_in"         => ":attribute wahl ungültig.",
	"numeric"        => ":attribute muss eine zahl sein.",
	"required"       => ":attribute feld ist erforderlich.",
	"same"           => ":attribute und :other müssen übereinstimmen.",
	"size"           => array(
		"numeric" => ":attribute muss :size sein.",
		"file"    => ":attribute muss :size kilobyte sein.",
		"string"  => ":attribute muss :size karakter sein.",
	),
	"unique"         => ":attribute ist bereits eingetragen.",
	"url"            => ":attribute format ist ungültig.",

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

	'custom' => array(),

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

	'attributes' => array(),

);