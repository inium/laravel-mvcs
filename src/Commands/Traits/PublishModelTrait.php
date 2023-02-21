<?php

namespace Inium\Multier\Commands\Traits;

trait PublishModelTrait
{
    /**
     * Publish model
     * - Make a model, factory, migration, seeder, and feature test
     *
     * @param string $name  class name
     * @return void
     */
    protected function publishModel(string $name): void
    {
        $this->call("make:model", [
            "name" => "{$name}",
            "--factory" => true,
            "--migration" => true,
            "--seed" => true,
            "--test" => true,
        ]);
    }
}
