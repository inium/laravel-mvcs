<?php

namespace Inium\Mvcs\Commands\Traits;

trait PublishDtosTrait
{
    use PublishStubTrait;

    /**
     * Publish content data transfer object
     *
     * @param string $name      class name
     * @param object $dtoConf   content data transfer object config
     * @return void
     */
    protected function publishContentDto(string $name, object $dtoConf): void
    {
        // prettier-ignore
        $namespace = str_replace("{{ class }}", $name, $dtoConf->namespace);
        $class = str_replace("{{ class }}", $name, $dtoConf->classname);
        $putPath = str_replace("{{ class }}", $name, $dtoConf->path);

        $this->publishStub($dtoConf->stub, $putPath, [
            "{{ namespace }}" => $namespace,
            "{{ class }}" => $class,
        ]);
    }

    /**
     * Publish paginate data transfer object
     *
     * @param string $name      class name
     * @param object $dtoConf   create data transfer object config
     * @return void
     */
    protected function publishPageDto(string $name, object $dtoConf): void
    {
        $namespace = str_replace("{{ class }}", $name, $dtoConf->namespace);
        $class = str_replace("{{ class }}", $name, $dtoConf->classname);
        $putPath = str_replace("{{ class }}", $name, $dtoConf->path);

        $this->publishStub($dtoConf->stub, $putPath, [
            "{{ namespace }}" => $namespace,
            "{{ class }}" => $class,
        ]);
    }

    /**
     * Publish create data transfer object
     *
     * @param string $name      class name
     * @param object $dtoConf   create data transfer object config
     * @return void
     */
    protected function publishCreateDto(string $name, object $dtoConf): void
    {
        $namespace = str_replace("{{ class }}", $name, $dtoConf->namespace);
        $class = str_replace("{{ class }}", $name, $dtoConf->classname);
        $putPath = str_replace("{{ class }}", $name, $dtoConf->path);

        $this->publishStub($dtoConf->stub, $putPath, [
            "{{ namespace }}" => $namespace,
            "{{ class }}" => $class,
        ]);
    }

    /**
     * Publish update data transfer object
     *
     * @param string $name      class name
     * @param object $dtoConf   update data transfer object config
     * @return void
     */
    protected function publishUpdateDto(string $name, object $dtoConf): void
    {
        $namespace = str_replace("{{ class }}", $name, $dtoConf->namespace);
        $class = str_replace("{{ class }}", $name, $dtoConf->classname);
        $putPath = str_replace("{{ class }}", $name, $dtoConf->path);

        $this->publishStub($dtoConf->stub, $putPath, [
            "{{ namespace }}" => $namespace,
            "{{ class }}" => $class,
        ]);
    }
}
