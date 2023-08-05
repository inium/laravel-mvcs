<?php

namespace Inium\Mvcs\Commands\Traits;

trait PublishServicesTrait
{
    use PublishStubTrait;

    /**
     * Publish service interface
     *
     * @param string $name              class name
     * @param object $servInterfConf    service interface config
     * @param object $dtoConf           data transfer object config
     * @return void
     */
    public function publishServiceInterface(
        string $name,
        object $servInterfConf,
        object $dtoConf
    ): void {
        $ns = str_replace("{{ class }}", $name, $servInterfConf->namespace);
        $class = str_replace("{{ class }}", $name, $servInterfConf->classname);
        $path = str_replace("{{ class }}", $name, $servInterfConf->path);

        $this->publishStub($servInterfConf->stub, $path, [
            "{{ namespace }}" => $ns,
            "{{ contentDtoNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->content->namespace
            ),
            "{{ createDtoNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->create->namespace
            ),
            "{{ updateDtoNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->update->namespace
            ),
            "{{ contentDtoClass }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->content->classname
            ),
            "{{ createDtoClass }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->create->classname
            ),
            "{{ updateDtoClass }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->update->classname
            ),
            "{{ class }}" => $class,
        ]);
    }

    /**
     * Publish service interface
     *
     * @param string $name              class name
     * @param object $repoInterfConf    repository interface config
     * @param object $servInterfConf    service interface config
     * @param object $servConf          service config
     * @param object $dtoConf           data transfer object config
     * @return void
     */
    public function publishService(
        string $name,
        object $repoInterfConf,
        object $servInterfConf,
        object $servConf,
        object $dtoConf
    ): void {
        $ns = str_replace("{{ class }}", $name, $servConf->namespace);
        $class = str_replace("{{ class }}", $name, $servConf->classname);
        $path = str_replace("{{ class }}", $name, $servConf->path);

        $this->publishStub($servConf->stub, $path, [
            "{{ namespace }}" => $ns,
            "{{ repositoryInterfaceNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $repoInterfConf->namespace
            ),
            "{{ repositoryInterfaceClass }}" => str_replace(
                "{{ class }}",
                $name,
                $repoInterfConf->classname
            ),
            "{{ serviceInterfaceNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $servInterfConf->namespace
            ),
            "{{ serviceInterfaceClass }}" => str_replace(
                "{{ class }}",
                $name,
                $servInterfConf->classname
            ),
            "{{ contentDtoNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->content->namespace
            ),
            "{{ createDtoNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->create->namespace
            ),
            "{{ updateDtoNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->update->namespace
            ),
            "{{ contentDtoClass }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->content->classname
            ),
            "{{ createDtoClass }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->create->classname
            ),
            "{{ updateDtoClass }}" => str_replace(
                "{{ class }}",
                $name,
                $dtoConf->update->classname
            ),
            "{{ class }}" => $class,
        ]);
    }
}
