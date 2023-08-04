<?php

return [
    "model" => [
        "namespace" => "App\Models",
    ],

    // Controller
    "controller" => [
        "classname" => "{{ class }}Controller",
        "namespace" => "App\Http\Controllers",
        "path" => "app/Http/Controllers/{{ class }}Controller.php",
        "stub" => __DIR__ . "/../Publishes/Stubs/controller.api.stub",
    ],

    // request
    "request" => [
        "page" => [
            "classname" => "Page{{ class }}Request",
            "namespace" => "App\Http\Requests\{{ class }}",
            "path" =>
                "app/Http/Requests/{{ class }}/Page{{ class }}Request.php",
            "stub" =>
                __DIR__ . "/../Publishes/Stubs/Requests/page-request.stub",
        ],
        "create" => [
            "classname" => "Create{{ class }}Request",
            "namespace" => "App\Http\Requests\{{ class }}",
            "path" =>
                "app/Http/Requests/{{ class }}/Create{{ class }}Request.php",
            "stub" =>
                __DIR__ . "/../Publishes/Stubs/Requests/create-request.stub",
        ],
        "update" => [
            "classname" => "Update{{ class }}Request",
            "namespace" => "App\Http\Requests\{{ class }}",
            "path" =>
                "app/Http/Requests/{{ class }}/Update{{ class }}Request.php",
            "stub" =>
                __DIR__ . "/../Publishes/Stubs/Requests/update-request.stub",
        ],
    ],

    "module" => [
        "repositoryInterface" => [
            "classname" => "{{ class }}RepositoryInterface",
            "namespace" => "App\Modules\{{ class }}\Interfaces",
            "path" =>
                "app/Modules/{{ class }}/Interfaces/{{ class }}RepositoryInterface.php",
            "stub" =>
                __DIR__ .
                "/../Publishes/Stubs/Module/Interfaces/repository-interface.stub",
        ],
        "serviceInterface" => [
            "classname" => "{{ class }}ServiceInterface",
            "namespace" => "App\Modules\{{ class }}\Interfaces",
            "path" =>
                "app/Modules/{{ class }}/Interfaces/{{ class }}ServiceInterface.php",
            "stub" =>
                __DIR__ .
                "/../Publishes/Stubs/Module/Interfaces/service-interface.stub",
        ],
        "repository" => [
            "classname" => "{{ class }}Repository",
            "namespace" => "App\Modules\{{ class }}",
            "path" => "app/Modules/{{ class }}/{{ class }}Repository.php",
            "stub" => __DIR__ . "/../Publishes/Stubs/Module/repository.stub",
        ],
        "service" => [
            "classname" => "{{ class }}Service",
            "namespace" => "App\Modules\{{ class }}",
            "path" => "app/Modules/{{ class }}/{{ class }}Service.php",
            "stub" => __DIR__ . "/../Publishes/Stubs/Module/service.stub",
        ],
        "dto" => [
            "content" => [
                "classname" => "{{ class }}Dto",
                "namespace" => "App\Modules\{{ class }}\Dto",
                "path" => "app/Modules/{{ class }}/Dto/{{ class }}Dto.php",
                "stub" => __DIR__ . "/../Publishes/Stubs/Module/Dto/dto.stub",
            ],
            "page" => [
                "classname" => "Page{{ class }}Dto",
                "namespace" => "App\Modules\{{ class }}\Dto",
                "path" => "app/Modules/{{ class }}/Dto/Page{{ class }}Dto.php",
                "stub" =>
                    __DIR__ . "/../Publishes/Stubs/Module/Dto/page-dto.stub",
            ],
            "create" => [
                "classname" => "Create{{ class }}Dto",
                "namespace" => "App\Modules\{{ class }}\Dto",
                "path" =>
                    "app/Modules/{{ class }}/Dto/Create{{ class }}Dto.php",
                "stub" =>
                    __DIR__ . "/../Publishes/Stubs/Module/Dto/Create-dto.stub",
            ],
            "update" => [
                "classname" => "Update{{ class }}Dto",
                "namespace" => "App\Modules\{{ class }}\Dto",
                "path" =>
                    "app/Modules/{{ class }}/Dto/Update{{ class }}Dto.php",
                "stub" =>
                    __DIR__ . "/../Publishes/Stubs/Module/Dto/update-dto.stub",
            ],
        ],
    ],
];
