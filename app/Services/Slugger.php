<?php
namespace App\Services;

use Illuminate\Support\Str;

class Slugger
{
    /**
     * Generate a slug from a given string.
     *
     * @param  string  $string
     * @return string
     */
    public static function generate($string)
    {
        return Str::slug($string, '-');
    }
}
