<?php

namespace Inium\Multier\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Inium\Multier\Commands\Traits\PublishModelTrait;
use Inium\Multier\Commands\Traits\PublishRepositoriesTrait;
use Inium\Multier\Commands\Traits\PublishServicesTrait;
use Inium\Multier\Commands\Traits\PublishDtosTrait;
use Inium\Multier\Commands\Traits\PublishRequestsTrait;
use Inium\Multier\Commands\Traits\PublishControllerTrait;
use Inium\Multier\Common\Traits\ArrayToObjectTrait;

class CreateCommand extends Command
{
    use ArrayToObjectTrait;
    use PublishModelTrait;
    use PublishRequestsTrait;
    use PublishRepositoriesTrait;
    use PublishServicesTrait;
    use PublishDtosTrait;
    use PublishControllerTrait;

    /**
     * The name and signature of the console command.
     *
     * - If module option is not defined, the command will create module scaffolds only in below:
     *   * Repository
     *   * Service
     *   * DTO
     *   * Request
     * - Else the command will create all of scaffolds in below:
     *   * Controller
     *   * Request
     *   * Module(Service, Repository, DTO),
     *   * Database(Model, Factory, Migration, Seeder)
     *
     * @var string
     */
    protected $signature = "multier:create
        {name : Class name}
        {?--module : Create module (Request, Repository, Service, DTO) - except database - only or not}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a set of Layered Architecture Scaffolds: Controller, Requests(List, Create, Update), Module(Service, Repository, DTO), Database(Model, Factory, Migration, Seeder) and a Feature test.";

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        try {
            $name = ucfirst($this->argument("name"));
            $module = $this->option("module"); // true if used false otherwise

            $conf = config("multier");
            $conf = $this->arrayToObject($conf);

            $module ? $this->module($name, $conf) : $this->all($name, $conf);

            return 0;
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
            return 0;
        }
    }

    /**
     * Create all multier scaffolds in below:
     * - Model(Model, Factory, Migration, Seeder, Test(feature))
     * - Requests(List, Create, Update)
     * - Module(Service, Repository, DTO)
     * - Database(Factory, Migration, Seeder)
     * - Controller
     *
     * @param string $name
     * @param object $config
     * @return void
     */
    protected function all(string $name, object $config): void
    {
        $this->model($name);
        $this->module($name, $config);
    }

    /**
     * Create scaffolds except databases
     *
     * @param string $name
     * @param object $config
     * @return void
     */
    protected function module(string $name, object $config): void
    {
        $this->requests($name, $config);
        $this->repositories($name, $config);
        $this->services($name, $config);
        $this->dtos($name, $config);
        $this->controller($name, $config);
    }

    /**
     * Create database (model, factory, migration, seeders, test(feature))
     *
     * @param string $name
     * @return void
     */
    private function model(string $name): void
    {
        $this->publishModel($name);
    }

    /**
     * Create Requests (list, create, update)
     *
     * @param string $name
     * @param object $config
     * @return void
     */
    private function requests(string $name, object $config): void
    {
        $reqConf = $config->request;
        $dtoConf = $config->module->dto;

        // Publish Requests
        $this->publishListRequest($name, $reqConf->list);
        $this->publishCreateRequest($name, $reqConf->create, $dtoConf->create);
        $this->publishUpdateRequest($name, $reqConf->update, $dtoConf->update);
    }

    /**
     * Create repository (interface, concrete)
     *
     * @param string $name
     * @param object $config
     * @return void
     */
    private function repositories(string $name, object $config): void
    {
        $modelConf = $config->model;
        $moduleConf = $config->module;
        $repoInterfConf = $moduleConf->repositoryInterface;
        $repoConf = $moduleConf->repository;

        // Publish Repository
        $this->publishRepositoryInterface($name, $repoInterfConf);
        $this->publishRepository($name, $modelConf, $repoInterfConf, $repoConf);
    }

    /**
     * Create services (interface, concrete)
     *
     * @param string $name
     * @param object $config
     * @return void
     */
    private function services(string $name, object $config): void
    {
        $moduleConf = $config->module;
        $repoInterfConf = $moduleConf->repositoryInterface;
        $servInterfConf = $moduleConf->serviceInterface;
        $servConf = $moduleConf->service;
        $dtoConf = $moduleConf->dto;

        // Publish Service
        $this->publishServiceInterface($name, $servInterfConf, $dtoConf);
        $this->publishService(
            $name,
            $repoInterfConf,
            $servInterfConf,
            $servConf,
            $dtoConf
        );
    }

    /**
     * Create DTOs (content, create, update)
     *
     * @param string $name
     * @param object $config
     * @return void
     */
    private function dtos(string $name, object $config): void
    {
        $dtoConf = $config->module->dto;

        // Publish DTO
        $this->publishContentDto($name, $dtoConf->content);
        $this->publishCreateDto($name, $dtoConf->create);
        $this->publishUpdateDto($name, $dtoConf->update);
    }

    /**
     * Create a controller
     *
     * @param string $name
     * @param object $config
     * @return void
     */
    private function controller(string $name, object $config): void
    {
        $reqConf = $config->request;
        $moduleConf = $config->module;
        $servInterfConf = $moduleConf->serviceInterface;
        $ctrlConf = $config->controller;

        // Publish Controller
        $this->publishController($name, $ctrlConf, $reqConf, $servInterfConf);
    }
}
