<?php

namespace App\Http\Requests\Items;

use App\Repositories\Helpers\NumberFormatRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

class UpdateItemRequest extends FormRequest
{
    private $numberFormatRepository;

    public function __construct(
        NumberFormatRepository $numberFormatRepository
    ) {
        $this->numberFormatRepository = $numberFormatRepository;
    }

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'thumbnail' => 'nullable|file|mimes:jpeg,jpg,png',
            "is_thumbnail_removed" => "nullable|boolean",
            "status" => "nullable|boolean",
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|string|exists:App\Models\ItemCategory,id',
            'details' => 'required|array|min:1',
            'details.*.unit_of_measurement' => 'required|string|exists:App\Models\UnitOfMeasurement,id',
            'details.*.quantity' => 'nullable|numeric',
            'details.*.cost' => 'nullable|numeric',
            'details.*.status' => 'nullable|boolean',
            'codes' => 'nullable|array',
            'codes.*' => 'required|string',
        ];
    }

    public function data(): array
    {
        return [
            'name' => $this->input('name'),
            'thumbnail_url' => $this->getFile('item-thumbnails', 'thumbnail'),
            'is_thumbnail_removed' => $this->boolean('is_thumbnail_removed'),
            'is_active' => $this->boolean('status'),
            'categories' => $this->input('categories'),
            'details' => $this->getItemDetails(),
            'codes' => $this->input('codes'),
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

    public function getItemDetails()
    {
        $items = $this->input('details');
        $data = [];
        if ($items) {
            foreach ($items as $item) {
                $data[] = [
                    'unit_of_measurement_id' => $item['unit_of_measurement'],
                    'quantity' => $this->numberFormatRepository->stringToNumber($item['quantity']),
                    'cost' => $this->numberFormatRepository->stringToNumber($item['cost']),
                    'is_active' => array_key_exists('status', $item) && $item['status'] === '1',
                ];
            }
        }

        return $data;
    }
}
