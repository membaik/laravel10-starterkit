<?php

namespace App\Repositories\Helpers;

use Illuminate\Support\Facades\Storage;

class FileRepository
{
    public function remove($fileUrl): bool
    {
        if (Storage::disk('public')->exists($fileUrl) && Storage::disk('public')->delete($fileUrl)) {
            return true;
        }

        return false;
    }

    public function moveFromTemporaryDirectoryToTargetDirectory($temporaryUrl, $targetDirectory): string
    {
        if (Storage::disk('public')->exists($temporaryUrl)) {
            $fileName = str_replace('temporary-files/', '', $temporaryUrl);
            if (Storage::disk('public')->move($temporaryUrl, $newUrl = $targetDirectory . '/' . $fileName)) {
                return $newUrl;
            }
        }

        return $temporaryUrl;
    }
}
