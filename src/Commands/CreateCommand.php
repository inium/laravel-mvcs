<?php

namespace Inium\Mvcs\Commands;

use Illuminate\Console\Command;
use Inium\Mvcs\Commands\Traits\PublishModelTrait;
use Inium\Mvcs\Commands\Traits\PublishRepositoriesTrait;
use Inium\Mvcs\Commands\Traits\PublishServicesTrait;
use Inium\Mvcs\Commands\Traits\PublishDtosTrait;
use Inium\Mvcs\Commands\Traits\PublishRequestsTrait;
use Inium\Mvcs\Commands\Traits\PublishControllerTrait;
use Inium\Mvcs\Common\Traits\ArrayTrait;

class CreateCommand extends Command
{
    use ArrayTrait;
    use PublishModelTrait;
    use PublishRequestsTrait;
    use PublishRepositoriesTrait;
    use PublishServicesTrait;
    use PublishDtosTrait;
    use PublishControllerTrait;

    /**
     * The name and signature of the console command.
     *
     * Layered Architecutre 를 위한 모듈 Set을 생성하는 콘솔 명령어
     * - Module: Controller, Repository, Service, DTO(Data Transfer Object), Request (Page, Store, Update)
     * - Database: Model, Factory, Migration, Seeds
     *
     * @var string
     */
    protected $signature = "mvcs:create
        {name : Class name}
        {?--module : Create module (Controller, Request, Repository, Service, DTO) only}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a set of layered architecture scaffolds";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
            $module = $this->option("module");

            $conf = config("mvcs");
            $conf = $this->toObject($conf);

            // module 옵션이 존재하면 module만 생성 / else 모두 생성
            $module ? $this->module($name, $conf) : $this->all($name, $conf);

            return 0;
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
            return 0;
        }
    }

    /**
     * 모든 구성요소를 생성한다 (아래 항목)
     * - Model(Model, Factory, Migration, Seeder, Test(feature))
     * - Requests(Page, Store, Update)
     * - Module(Service, Repository, DTO)
     * - Database(Factory, Migration, Seeder)
     * - Controller
     *
     * @param string $name      모듈 이름
     * @param object $config    환경설정 정보
     * @return void
     */
    protected function all(string $name, object $config): void
    {
        $this->model($name);
        $this->module($name, $config);
    }

    /**
     * 데이터베이스 관련 모듈을 제외한 아래 구성요소를 생성한다
     * - Model(Model, Factory, Migration, Seeder, Test(feature))
     * - Requests(Page, Store, Update)
     * - Module(Service, Repository, DTO)
     * - Database(Factory, Migration, Seeder)
     *
     * @param string $name      모듈 이름
     * @param object $config    환경설정 정보
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
     * 데이터베이스 모듈을 생성한다
     * - model, factory, migration, seeders, test(feature)
     *
     * @param string $name  모듈 이름
     * @return void
     */
    private function model(string $name): void
    {
        $this->publishModel($name);
    }

    /**
     * Request들을 생성한다
     * - PageRequest: 목록 Request
     * - StoreRequest: 생성 Request
     * - UpdateRequest: 갱신 Request
     *
     * @param string $name      모듈 이름
     * @param object $config    환경설정 정보
     * @return void
     */
    private function requests(string $name, object $config): void
    {
        $reqConf = $config->request;
        $dtoConf = $config->module->dto;

        $this->publishPageRequest($name, $reqConf->page);
        $this->publishStoreRequest($name, $reqConf->store, $dtoConf->store);
        $this->publishUpdateRequest($name, $reqConf->update, $dtoConf->update);
    }

    /**
     * Repository interface - concrete 클래스를 생성한다
     * - interface class: 모듈의 Repository 인터페이스 클래스
     * - concrete: Repository interface 를 상속받아 구현하는 구현체
     *
     * @param string $name      모듈 이름
     * @param object $config    환경설정 정보
     * @return void
     */
    private function repositories(string $name, object $config): void
    {
        $modelConf = $config->model;
        $moduleConf = $config->module;
        $repoInterfConf = $moduleConf->repositoryInterface;
        $repoConf = $moduleConf->repository;

        $this->publishRepositoryInterface($name, $repoInterfConf);
        $this->publishRepository($name, $modelConf, $repoInterfConf, $repoConf);
    }

    /**
     * Service interface - concrete 클래스들을 생성한다.
     * - interface class: 모듈의 Service 인터페이스 클래스
     * - concrete: Service interface 를 상속받아 구현하는 구현체
     *
     * @param string $name      모듈 이름
     * @param object $config    환경설정 정보
     * @return void
     */
    private function services(string $name, object $config): void
    {
        $moduleConf = $config->module;
        $repoInterfConf = $moduleConf->repositoryInterface;
        $servInterfConf = $moduleConf->serviceInterface;
        $servConf = $moduleConf->service;
        $dtoConf = $moduleConf->dto;

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
     * DTO(Data Transfer Object) 클래스들을 생성한다 (아래 항목)
     * - PageDto: 콘텐츠 목록 저장 DTO
     * - ContentDto: 콘텐츠 DTO
     * - StoreDto: 콘텐츠 생성 DTO
     * - UpdateDto: 콘텐츠 갱신 DTO
     *
     * @param string $name      모듈 이름
     * @param object $config    환경설정 정보
     * @return void
     */
    private function dtos(string $name, object $config): void
    {
        $dtoConf = $config->module->dto;

        // Publish DTO
        $this->publishContentDto($name, $dtoConf->content);
        $this->publishPageDto($name, $dtoConf->page);
        $this->publishStoreDto($name, $dtoConf->store);
        $this->publishUpdateDto($name, $dtoConf->update);
    }

    /**
     * Controller를 생성한다.
     *
     * @param string $name      모듈 이름
     * @param object $config    환경설정 정보
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
