<?php

namespace Inium\Multier\Commands\Traits;

trait PublishStubTrait
{
    /**
     * Publish a stub
     *
     * @param string $src   source stub path
     * @param string $dest  target(publish) path
     * @param array $sr     searchReplace contents to be replace stub sentences
     * @return void
     */
    protected function publishStub(
        string $stubPath,
        string $destPath,
        array $searchReplace
    ): void {
        // from package root path
        $code = file_get_contents($stubPath);

        $search = array_keys($searchReplace);
        $replace = array_values($searchReplace);

        $template = str_replace($search, $replace, $code);

        // Check file published or not: avoid overwriting
        if ($this->files->exists($destPath)) {
            $this->components->error("Can't locate path: <{$destPath}>");
            return;
        }

        // Check directory exists and create if not exists
        $this->ensureDirectoryExists($destPath);

        // Render publish status to console
        $this->components->task(
            sprintf("Publishing [%s]", base_path($destPath))
        );

        file_put_contents(base_path($destPath), $template);
    }

    /**
     * Ensure directory exists from put file path
     *
     * @param string $putPath
     * @return void
     */
    private function ensureDirectoryExists(string $putPath)
    {
        $dir = substr($putPath, 0, strrpos($putPath, "/"));
        $this->files->ensureDirectoryExists($dir);
    }
}
