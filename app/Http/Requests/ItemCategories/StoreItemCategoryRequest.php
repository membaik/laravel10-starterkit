<?php

namespace App\Http\Requests\ItemCategories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class StoreItemCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'thumbnail' => 'nullable|file|mimes:jpeg,jpg,png',
            "status" => "nullable|boolean",
        ];
    }

    public function data(): array
    {
        return [
            'name' => $this->input('name'),
            'thumbnail_url' => $this->getFile('item-category-thumbnails', 'thumbnail'),
            'is_active' => $this->boolean('status'),
        ];
    }

    public function getFile($fileDirectory, $parameter): ?string
    {
        $fileUrl = null;
        if ($this->hasFile($parameter)) {
            $file          = $this->file($parameter);
            do {
                $fileName      = date('Y_m_d_His_') . $file->hashName();
            } while (Storage::disk('public')->exists($fileDirectory . '/' . $fileName));
            $fileUrl    = $file->storeAs($fileDirectory, $fileName, 'public');
        }

        return $fileUrl;
    }
}
