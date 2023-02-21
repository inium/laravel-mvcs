<?php

namespace Inium\Mvcs\Commands\Traits;

trait PublishControllerTrait
{
    use PublishStubTrait;

    /**
     * Controller를 Publish 한다.
     *
     * @param string $name              Controller 이름
     * @param object $ctrlConfig        Controller 설정정보 (mvcs.php)
     * @param object $reqConf           Request 설정정보 (mvcs.php)
     * @param object $servInterfConfig  Service  설정정보 (mvcs.php)
     * @return void
     */
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
            "{{ pageRequestNamespace }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->page->namespace
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
            "{{ pageRequestClass }}" => str_replace(
                "{{ class }}",
                $name,
                $reqConf->page->classname
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
