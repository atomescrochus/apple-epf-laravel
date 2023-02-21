<?php

namespace Appwapp\EPF\Traits;

use Illuminate\Support\Collection;

trait FileStorage
{
    /**
     * Get the EPF files paths
     *
     * @return \Illuminate\Support\Collection
     */
    public function getEPFFilesPaths(): Collection
    {
        $systemPaths = (object) [
            'storage'    => storage_path('app/'),
            'epf_folder' => storage_path('app/' . config('apple-epf.storage_folder')),
            'archive'    => storage_path('app/' . config('apple-epf.storage_folder') . '/' . config('apple-epf.archive_folder')),
            'extraction' => storage_path('app/' . config('apple-epf.storage_folder') . '/' . config('apple-epf.extraction_folder')),
        ];

        $storagePaths = (object) [
            'storage'    => storage_path('app/'),
            'epf_folder' => config('apple-epf.storage_folder'),
            'archive'    => config('apple-epf.storage_folder') . '/' . config('apple-epf.archive_folder'),
            'extraction' => config('apple-epf.storage_folder') . '/' . config('apple-epf.extraction_folder'),
        ];

        return collect([
            'system'  => $systemPaths,
            'storage' => $storagePaths,
        ]);
    }
}
