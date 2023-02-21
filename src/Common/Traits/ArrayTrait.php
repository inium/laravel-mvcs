<?php

namespace Inium\Mvcs\Common\Traits;

use Illuminate\Support\Str;

trait ArrayTrait
{
    /**
     * 배열 키를 camelCase로 recursively 하게 변환한 후 반환한다.
     *
     * @param array $array
     * @return array
     */
    public function keysToCamel(array $arr): array
    {
        $result = [];
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $value = $this->keysToCamel($value);
            }

            $result[Str::camel($key)] = $value;
        }
        return $result;
    }

    /**
     * 배열 키를 snake_case로 recursively 하게 변환한 후 반환한다.
     *
     * @param array $array
     * @return array
     */
    public function keysToSnake(array $arr): array
    {
        $result = [];
        foreach ($arr as $key => $value) {
            if (is_array($value)) {
                $value = $this->keysToSnake($value);
            }

            $result[Str::snake($key)] = $value;
        }
        return $result;
    }

    /**
     * Array to Object
     *
     * @param array $array
     * @return object
     * @see https://stackoverflow.com/questions/4790453/php-recursive-array-to-object
     */
    private function toObject(array $array): object
    {
        $obj = new \stdClass();

        foreach ($array as $k => $v) {
            if (strlen($k)) {
                if (is_array($v)) {
                    $obj->{$k} = $this->toObject($v); //RECURSION
                } else {
                    $obj->{$k} = $v;
                }
            }
        }

        return $obj;
    }
}
