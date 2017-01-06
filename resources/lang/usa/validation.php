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

	"accepted"       => ":attribute should be accepted.",
	"active_url"     => ":attribute must be a valid URL.",
	"after"          => ":attribute these must be an earlier :date.",
	"alpha"          => ":attribute should only consist of letters.",
	"alpha_dash"     => ":attribute only letters, numbers, and dashes should be composed.",
	"alpha_num"      => ":attribute should contain only letters and numbers.",
	"before"         => ":attribute these must be a date earlier :date.",
	"between"        => array(
		"numeric" => "must be between :attribute :min - :max",
		"file"    => "Should be the kilobyte value between :attribute :min - :max",
		"string"  => "Should consist charecters between :attribute :min - :max",
	),
	"confirmed"      => ":attribute not confirmed.",
	"different"      => ":attribute and :other must be different from each other.",
	"email"          => ":attribute format is not valid.",
	"exists"         => "Seçili :attribute is not valid.",
	"image"          => ":attribute should be image file.",
	"in"             => "selected :attribute is not valid.",
	"integer"        => ":attribute should be a number.",
	"ip"             => ":attribute should be valid IP address.",
	"match"          => ":attribute format is invalid.",
	"max"            => array(
		"numeric" => ":attribute should be smaller than :max.",
		"file"    => ":attribute should be smaller than :max kilobyte.",
		"string"  => ":attribute should be smaller than :max character.",
	),
	"mimes"          => ":attribute file format should be :values .",
	"min"            => array(
		"numeric" => ":attribute at least should be :min .",
		"file"    => ":attribute at least should be :min kilobyte.",
		"string"  => ":attribute at least should be :min character.",
	),
	"not_in"         => "selected :attribute is invalid.",
	"numeric"        => ":attribute should be numeric.",
	"required"       => ":attribute field is required.",
	"same"           => ":attribute should match with :other",
	"size"           => array(
		"numeric" => ":attribute should be :size.",
		"file"    => ":attribute should be :size kilobyte.",
		"string"  => ":attribute should be :size character.",
	),
	"unique"         => ":attribute has already been registered.",
	"url"            => ":attribute format is invalid.",

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