<?php

namespace Inium\Mvcs\Commands\Traits;

trait PublishRequestsTrait
{
    use PublishStubTrait;

    /**
     * Publish page request
     *
     * @param string $name          class name
     * @param object $reqConfig     request config
     * @return void
     */
    protected function publishPageRequest(string $name, object $reqConfig): void
    {
        $ns = str_replace("{{ class }}", $name, $reqConfig->namespace);
        $class = str_replace("{{ class }}", $name, $reqConfig->classname);
        $path = str_replace("{{ class }}", $name, $reqConfig->path);

        $this->publishStub($reqConfig->stub, $path, [
            "{{ namespace }}" => $ns,
            "{{ class }}" => $class,
        ]);
    }

    /**
     * Publish create request
     *
     * @param string $name          class name
     * @param object $reqConfig     request config
     * @param object $dtoConfig     dto config
     * @return void
     */
    protected function publishCreateRequest(
        string $name,
        object $reqConfig,
        object $dtoConfig
    ): void {
        $path = str_replace("{{ class }}", $name, $reqConfig->path);
        $ns = str_replace("{{ class }}", $name, $reqConfig->namespace);
        $class = str_replace("{{ class }}", $name, $reqConfig->classname);
        $dtoNs = str_replace("{{ class }}", $name, $dtoConfig->namespace);
        $dtoClass = str_replace("{{ class }}", $name, $dtoConfig->classname);

        $this->publishStub($reqConfig->stub, $path, [
            "{{ namespace }}" => $ns,
            "{{ class }}" => $class,
            "{{ dtoNamespace }}" => "{$dtoNs}",
            "{{ dtoClass }}" => $dtoClass,
        ]);
    }

    /**
     * Publish update request
     *
     * @param string $name          class name
     * @param object $reqConfig     request config
     * @param object $dtoConfig     dto config
     * @return void
     */
    protected function publishUpdateRequest(
        string $name,
        object $reqConfig,
        object $dtoConfig
    ): void {
        $path = str_replace("{{ class }}", $name, $reqConfig->path);
        $ns = str_replace("{{ class }}", $name, $reqConfig->namespace);
        $class = str_replace("{{ class }}", $name, $reqConfig->classname);
        $dtoNs = str_replace("{{ class }}", $name, $dtoConfig->namespace);
        $dtoClass = str_replace("{{ class }}", $name, $dtoConfig->classname);

        $this->publishStub($reqConfig->stub, $path, [
            "{{ namespace }}" => $ns,
            "{{ class }}" => $class,
            "{{ dtoNamespace }}" => "{$dtoNs}\\{$dtoClass}",
            "{{ dtoClass }}" => $dtoClass,
        ]);
    }
}
