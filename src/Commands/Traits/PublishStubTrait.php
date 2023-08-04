<?php

namespace Inium\Mvcs\Commands\Traits;

use Illuminate\Support\Facades\File;

trait PublishStubTrait
{
    /**
     * Stub 코드를 Project에 Publish 한다
     *
     * @param string $src           Stub 코드 경로
     * @param string $dest          Stub를 Publish할 경로
     * @param array $searchReplace  Stub코드 내 검색 후 치환할 (search-replace할) 정보
     * @return void
     */
    protected function publishStub(
        string $stubPath,
        string $destPath,
        array $searchReplace
    ): void {
        $code = file_get_contents($stubPath);

        $search = array_keys($searchReplace);
        $replace = array_values($searchReplace);

        $template = str_replace($search, $replace, $code);

        if (file_exists(base_path($destPath))) {
            $this->components->error("Can't locate path: <{$destPath}>");
            return;
        }
        // Check directory exists and create if not exists
        $this->ensureDirectoryExists($destPath);

        // Render publish status to console
        $this->components->task(
            sprintf("Publishing [%s]", base_path($destPath))
        );

        File::put(base_path($destPath), $template);
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
        File::ensureDirectoryExists($dir);
    }
}
