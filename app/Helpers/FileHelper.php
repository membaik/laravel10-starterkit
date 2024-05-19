<?php

namespace App\Helpers;

class FileHelper
{
    public static function remove($fileUrl): float
    {
        if (Storage::disk('public')->exists($fileUrl)) {
            Storage::disk('public')->delete($fileUrl);

            return true;
        }

        return false;
    }
}
