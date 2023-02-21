<?php

namespace Inium\Multier\Common\Mapper;

use ReflectionClass;
use RuntimeException;
use JsonMapper;
use JsonMapper_Exception;
use Symfony\Component\HttpFoundation\ParameterBag;

class ModelMapper
{
    /**
     * map item array to class instance using reflection class name
     *
     * @param array $item
     * @param string $className     Reflection class name
     * @return mixed
     */
    public function map(array $item, string $className): mixed
    {
        try {
            $mapper = new JsonMapper();
            $mapper->bIgnoreVisibility = true;
            $mapper->bStrictNullTypes = false;

            return $mapper->map(
                new ParameterBag($item),
                (new ReflectionClass(
                    $className
                ))->newInstanceWithoutConstructor()
            );
        } catch (JsonMapper_Exception $e) {
            throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
