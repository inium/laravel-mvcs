<?php

namespace Inium\Multier\Commands\Traits;

trait PublishRepositoriesTrait
{
    use PublishStubTrait;

    /**
     * Publish repository interface
     *
     * @param string $name              class name
     * @param object $repoInterfConf    repository interface config
     * @return void
     */
    protected function publishRepositoryInterface(
        string $name,
        object $repoInterfConf
    ): void {
        // prettier-ignore
        $namespace = str_replace("{{ class }}", $name, $repoInterfConf->namespace);
        $class = str_replace("{{ class }}", $name, $repoInterfConf->classname);
        $putPath = str_replace("{{ class }}", $name, $repoInterfConf->path);

        $this->publishStub($repoInterfConf->stub, $putPath, [
            "{{ namespace }}" => $namespace,
            "{{ class }}" => $class,
        ]);
    }

    /**
     * Publish repository
     *
     * @param string $name              class name
     * @param object $modelConfig       model config
     * @param object $repoInterfConf    repository interface config
     * @param object $repoConf          repository config
     * @return void
     */
    protected function publishRepository(
        string $name,
        object $modelConfig,
        object $repoInterfConf,
        object $repoConf
    ): void {
        $namespace = str_replace("{{ class }}", $name, $repoConf->namespace);
        $class = str_replace("{{ class }}", $name, $repoConf->classname);
        $putPath = str_replace("{{ class }}", $name, $repoConf->path);
        $interfNamespace = str_replace(
            "{{ class }}",
            $name,
            $repoInterfConf->namespace
        );
        $interfClass = str_replace(
            "{{ class }}",
            $name,
            $repoInterfConf->classname
        );

        $this->publishStub($repoConf->stub, $putPath, [
            "{{ namespace }}" => $namespace,
            "{{ class }}" => $class,
            "{{ repositoryInterfaceNamespace }}" => $interfNamespace,
            "{{ repositoryInterfaceClass }}" => $interfClass,
            "{{ modelNamespace }}" => $modelConfig->namespace,
            "{{ modelClass }}" => $name,
        ]);
    }
}
