<?php

namespace App\Helpers;

class FileRepository
{
    public function remove($fileUrl): float
    {
        if (Storage::disk('public')->exists($fileUrl)) {
            Storage::disk('public')->delete($fileUrl);

            return true;
        }

        return false;
    }
}
