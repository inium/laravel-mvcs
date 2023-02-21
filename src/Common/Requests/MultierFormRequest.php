<?php

namespace Inium\Multier\Common\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Inium\Multier\Common\Mapper\ModelMapper;
use Inium\Multier\Common\Traits\ArrayTrait;

abstract class MultierFormRequest extends FormRequest
{
    use ArrayTrait;

    /**
     * ModelMapper
     *
     * @var ModelMapper
     */
    private ModelMapper $mapper;

    /**
     * Constructor
     *
     * @param ModelMapper $mapper
     */
    public function __construct(ModelMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * Set default values of parameter
     * - If the form request value is not defined.
     *
     * @return array|null
     */
    public function defaults(): ?array
    {
        return null;
    }

    /**
     * Get DTO(Data Transfer Object) class name
     *
     * @return string|null
     */
    public function dtoClassName(): ?string
    {
        return null;
    }

    /**
     * Instantiate DTO(Data Transfer Object)
     *
     * @return mixed        DTO class
     * @throws \Exception   DTO classname is null, 500
     */
    public function toDto(): mixed
    {
        try {
            $dtoClassName = $this->dtoClassName();
            if (is_null($dtoClassName)) {
                throw new \Exception("DTO classname is null", 500);
            }

            // Convert the array keys to camelCase
            $params = $this->arrayKeysToCamel($this->all());

            return $this->mapper->map($params, $dtoClassName);
        } catch (\Throwable $e) {
            abort($e->getcode(), $e->getMessage());
        }
    }

    /**
     * Prepare for validation
     * - If default value exists on the input field, define the default value.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // add default values
        $defaults = $this->defaults();
        if (!is_null($defaults)) {
            foreach ($this->defaults() as $key => $defaultValue) {
                if (!$this->has($key)) {
                    $this->merge([$key => $defaultValue]);
                }
            }
        }
    }
}
