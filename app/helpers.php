<?php

class localize {
    public function get() {
        return 'test';
    }

    function __toString()
    {
        return 'test';
    }
}

/**
 * Retrieve a language line.
 *
 * @param  string  $key
 * @param  array   $replacements
 * @param  string  $language
 * @return \Symfony\Component\Translation\TranslatorInterface|string
 */
function __($key, $replacements = array(), $language = null)
{
    return trans($key, $replacements, 'messages', $language);
}

function dj($value) {
    echo json_encode($value);
    die;
}

/**
 * Recursively remove slashes from array keys and values.
 *
 * @param  array  $array
 * @return array
 */
function array_strip_slashes($array)
{
    $result = array();

    foreach($array as $key => $value)
    {
        $key = stripslashes($key);

        // If the value is an array, we will just recurse back into the
        // function to keep stripping the slashes out of the array,
        // otherwise we will set the stripped value.
        if (is_array($value))
        {
            $result[$key] = array_strip_slashes($value);
        }
        else
        {
            $result[$key] = stripslashes($value);
        }
    }

    return $result;
}
