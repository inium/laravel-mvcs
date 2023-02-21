<?php

namespace Inium\Multier\Commands\Traits;

trait PublishControllerTrait
{
    use PublishStubTrait;

    protected function publishController(
        string $name,
        object $ctrlConfig,
        object $reqConf,
        object $servInterfConfig
    ): void {
        $namespace = str_replace("{{ class }}", $name, $ctrlConfig->namespace);
        $class = str_replace("{{ class }}", $name, $ctrlConfig->classname);
        $putPath = str_replace("{{ class }}", $name, $ctrlConfig->path);

        $this->publishStub($ctrlConfig->stub, $putPath, [
            "{{ namespace }}" => $namespace,
            "{{ class }}" => $class,
            "{{ listRequestNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->list->namespace
            ),
            "{{ createRequestNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->create->namespace
            ),
            "{{ updateRequestNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->update->namespace
            ),
            "{{ serviceInterfaceNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $servInterfConfig->namespace
            ),
            "{{ listRequestClass }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->list->classname
            ),
            "{{ createRequestClass }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->create->classname
            ),
            "{{ updateRequestClass }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->update->classname
            ),
            "{{ serviceInterfaceClass }}" => str_replace(
                "{{ class }}",
                $name,
                $servInterfConfig->classname
            ),
        ]);
    }
}
