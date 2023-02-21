<?php

namespace Inium\Mvcs\Common\Traits;

trait RegisterModuleTrait
{
    /**
     * Repository, Service 각각의 interface / concrete class 를 bind 한다.
     *
     * @return void
     */
    protected function registerModules(): void
    {
        $pathes = $this->getPublishPathes();

        foreach ($pathes as $p) {
            // 각 Path에 정의된 경로에서
            // 모든 service interface / concrete class 목록을 가져온다.
            // - {{ class }} 항목은 wildcard (*)로 대체
            $interfaces = $this->getClassesByDefinedPath($p["interface"]);
            $concretes = $this->getClassesByDefinedPath($p["concrete"]);

            foreach ($interfaces as $key => $interface) {
                $newKey = str_replace("Interface", "", $key);
                $concrete = $concretes[$newKey];

                $this->app->bind($interface, $concrete);
            }
        }
    }

    /**
     * Repository, Serivce interface / class 가 publish된 경로를 반환한다.
     *
     * @return array
     */
    protected function getPublishPathes(): array
    {
        // repository, serivce 파일들이 publish되는 경로
        return [
            "repository" => [
                "interface" => config("mvcs.module.repositoryInterface.path"),
                "concrete" => config("mvcs.module.repository.path"),
            ],
            "services" => [
                "interface" => config("mvcs.module.serviceInterface.path"),
                "concrete" => config("mvcs.module.service.path"),
            ],
        ];
    }

    /**
     * $path에 정의된 네임스페이스 포함 클래스 이름 목록을 반환한다.
     *
     * @param string $path  검색할 경로
     * @return array        클래스 목록
     */
    protected function getClassesByDefinedPath(string $path): array
    {
        $p = str_replace(["{{ class }}", "\\"], ["*", "/"], $path);
        $files = glob(base_path($p));

        $ret = [];

        collect($files)->each(function ($file) use (&$ret) {
            $basePath = base_path() . "/";
            $it = str_replace([$basePath, "/", ".php"], ["", "\\", ""], $file);

            // array key 값 추츨: class name으로 key 사용
            $pathes = explode("\\", $it);
            $k = end($pathes);

            $ret[$k] = ucfirst($it);
        });

        return $ret;
    }
}
