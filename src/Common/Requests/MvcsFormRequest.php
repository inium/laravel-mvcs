<?php

namespace Inium\Mvcs\Common\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Inium\Mvcs\Common\Mapper\ModelMapper;
use Inium\Mvcs\Common\Traits\ArrayTrait;

abstract class MvcsFormRequest extends FormRequest
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
     */
    public function __construct()
    {
        $this->mapper = new ModelMapper();
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
     * DTO 클래스 이름을 설정 & 반환한다.
     *
     * @return string|null
     */
    public function dtoClassName(): ?string
    {
        return null;
    }

    /**
     * Request parameter를 DTO(Data Transfer Object)로 반환한다.
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
            $params = $this->keysToCamel($this->all());

            return $this->mapper->map($params, $dtoClassName);
        } catch (\Throwable $e) {
            abort($e->getCode(), $e->getMessage());
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
