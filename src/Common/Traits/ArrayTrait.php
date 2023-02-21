<?php

namespace Inium\Multier\Common\Traits;

use Illuminate\Support\Str;

trait ArrayTrait
{
    /**
     * Convert array keys to camelCase recursively
     *
     * @param array $array
     * @return array
     */
    public function arrayKeysToCamel(array $arr): array
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
     * Convert array keys to snake_case recursively
     *
     * @param array $array
     * @return array
     */
    public function arrayKeysToSnake(array $arr): array
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
}
