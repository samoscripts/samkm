<?php

namespace App\Model;

class ArrayUtils
{
    public static function getRandomValue(array $array)
    {
        $randomKey = array_rand($array);
        return $array[$randomKey];
    }

    public static function popRandomValue(array &$array): mixed
{
    $randomKey = array_rand($array);
    $retValue = $array[$randomKey];
    unset($array[$randomKey]);
    return $retValue;
}

    public static function getRandomKey(mixed $races)
    {
        $randomKey = array_rand($races);
        return $randomKey;
    }
}