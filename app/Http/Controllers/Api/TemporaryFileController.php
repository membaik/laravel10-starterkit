<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemporaryFileController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $fileUrl = null;
        $fileDirectory = 'temporary-files';
        if ($request->hasFile('temporary_file')) {
            $file          = $request->file('temporary_file');
            do {
                $fileName      = date('Y_m_d_His_') . $file->hashName();
            } while (Storage::disk('public')->exists($fileDirectory . '/' . $fileName));
            $fileUrl    = $file->storeAs($fileDirectory, $fileName, 'public');

            return response()->json([
                'meta' => [
                    'success'   => true,
                    'code'      => 200,
                    'message'   => 'File uploaded successfully',
                    'errors'    => []
                ],
                'data' => $fileUrl,
            ]);
        } else {
            return response()->json([
                'meta' => [
                    'success'   => false,
                    'code'      => 500,
                    'message'   => 'File uploaded failed',
                    'errors'    => []
                ],
                'data' => null,
            ]);
        }
    }
}
