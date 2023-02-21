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
        "stub" => __DIR__ . "/../Stubs/controller.api.stub",
    ],

    // request
    "request" => [
        "list" => [
            "classname" => "List{{ class }}Request",
            "namespace" => "App\Http\Requests\{{ class }}",
            "path" =>
                "app/Http/Requests/{{ class }}/List{{ class }}Request.php",
            "stub" => __DIR__ . "/../Stubs/Requests/list-request.stub",
        ],
        "create" => [
            "classname" => "Create{{ class }}Request",
            "namespace" => "App\Http\Requests\{{ class }}",
            "path" =>
                "app/Http/Requests/{{ class }}/Create{{ class }}Request.php",
            "stub" => __DIR__ . "/../Stubs/Requests/create-request.stub",
        ],
        "update" => [
            "classname" => "Update{{ class }}Request",
            "namespace" => "App\Http\Requests\{{ class }}",
            "path" =>
                "app/Http/Requests/{{ class }}/Update{{ class }}Request.php",
            "stub" => __DIR__ . "/../Stubs/Requests/update-request.stub",
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
                "/../Stubs/Module/Interfaces/repository-interface.stub",
        ],
        "serviceInterface" => [
            "classname" => "{{ class }}ServiceInterface",
            "namespace" => "App\Modules\{{ class }}\Interfaces",
            "path" =>
                "app/Modules/{{ class }}/Interfaces/{{ class }}ServiceInterface.php",
            "stub" =>
                __DIR__ . "/../Stubs/Module/Interfaces/service-interface.stub",
        ],
        "repository" => [
            "classname" => "{{ class }}Repository",
            "namespace" => "App\Modules\{{ class }}",
            "path" => "app/Modules/{{ class }}/{{ class }}Repository.php",
            "stub" => __DIR__ . "/../Stubs/Module/repository.stub",
        ],
        "service" => [
            "classname" => "{{ class }}Service",
            "namespace" => "App\Modules\{{ class }}",
            "path" => "app/Modules/{{ class }}/{{ class }}Service.php",
            "stub" => __DIR__ . "/../Stubs/Module/service.stub",
        ],
        "dto" => [
            "content" => [
                "classname" => "{{ class }}Dto",
                "namespace" => "App\Modules\{{ class }}\Dto",
                "path" => "app/Modules/{{ class }}/Dto/{{ class }}Dto.php",
                "stub" => __DIR__ . "/../Stubs/Module/Dto/dto.stub",
            ],
            "create" => [
                "classname" => "Create{{ class }}Dto",
                "namespace" => "App\Modules\{{ class }}\Dto",
                "path" =>
                    "app/Modules/{{ class }}/Dto/Create{{ class }}Dto.php",
                "stub" => __DIR__ . "/../Stubs/Module/Dto/create-dto.stub",
            ],
            "update" => [
                "classname" => "Update{{ class }}Dto",
                "namespace" => "App\Modules\{{ class }}\Dto",
                "path" =>
                    "app/Modules/{{ class }}/Dto/Update{{ class }}Dto.php",
                "stub" => __DIR__ . "/../Stubs/Module/Dto/update-dto.stub",
            ],
        ],
    ],
];
