<?php

namespace Atomescrochus\EPF\Traits;

trait FileStorage
{
    // notes
    // storage_path() returns with no trailing slash
    

    public function getEPFFilesPaths()
    {
        $systemPaths = (object) [
            'storage' => storage_path("app/"),
            'epf_folder' => storage_path("app/".config('apple-epf.storage_folder')),
            'archive' => storage_path("app/".config('apple-epf.storage_folder')."/".config('apple-epf.archive_folder')),
            'extraction' => storage_path("/app/".config('apple-epf.storage_folder')."/".config('apple-epf.extraction_folder')),
        ];

        $storagePaths = (object) [
            'storage' => storage_path("app/"),
            'epf_folder' => config('apple-epf.storage_folder'),
            'archive' => config('apple-epf.storage_folder')."/".config('apple-epf.archive_folder'),
            'extraction' => config('apple-epf.storage_folder')."/".config('apple-epf.extraction_folder'),
        ];

        $paths = collect([
            'system' => $systemPaths,
            'storage' => $storagePaths,
        ]);

        return collect($paths);
    }
}
