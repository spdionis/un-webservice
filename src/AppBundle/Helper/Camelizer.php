<?php

namespace AppBundle\Helper;

class Camelizer
{
    /**
     * camelCase to snake_case.
     *
     * @param $value
     *
     * @return string
     */
    public static function snake_case($value)
    {
        return ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $value)), '_');
    }

    /**
     * snake_case to camelCase.
     *
     * @param $value
     *
     * @return string
     */
    public static function camelize($value)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $value))));
    }
}
