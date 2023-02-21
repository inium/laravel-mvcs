<?php

namespace Inium\Multier\Common\Traits;

trait ArrayToObjectTrait
{
    /**
     * Array to Object
     *
     * @param [type] $array
     * @return object
     * @see https://stackoverflow.com/questions/4790453/php-recursive-array-to-object
     */
    private function arrayToObject(array $array): object
    {
        $obj = new \stdClass();

        foreach ($array as $k => $v) {
            if (strlen($k)) {
                if (is_array($v)) {
                    $obj->{$k} = $this->arrayToObject($v); //RECURSION
                } else {
                    $obj->{$k} = $v;
                }
            }
        }

        return $obj;
    }
}
