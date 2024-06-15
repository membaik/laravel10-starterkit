<?php

namespace App\Repositories\Helpers;

use Illuminate\Support\Facades\Storage;

class FileRepository
{
    public function store($fileDirectory, $file): ?array
    {
        do {
            $fileName      = date('Y_m_d_His_') . $file->hashName();
        } while (Storage::disk('public')->exists($fileDirectory . '/' . $fileName));
        $fileUrl    = $file->storeAs($fileDirectory, $fileName, 'public') ?? null;

        return [
            'name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'extension' => $file->getClientOriginalExtension(),
            'size' => $file->getSize(),
            'location' => $fileUrl,
        ];
    }

    public function remove($fileUrl): bool
    {
        if (Storage::disk('public')->exists($fileUrl) && Storage::disk('public')->delete($fileUrl)) {
            return true;
        }

        return false;
    }

    public function moveFromTemporaryDirectoryToTargetDirectory($temporaryUrl, $targetDirectory)
    {
        if (Storage::disk('public')->exists($temporaryUrl)) {
            if (preg_match('/[^\/]+$/', $temporaryUrl, $matches)) {
                $fileName = $matches[0];
                $newUrl = $targetDirectory . '/' . $fileName;
            } else {
                $newUrl = $temporaryUrl;
            }

            if ($temporaryUrl !== $newUrl && Storage::disk('public')->move($temporaryUrl, $newUrl)) {
                return $newUrl;
            }
        }

        return $temporaryUrl;
    }
}
