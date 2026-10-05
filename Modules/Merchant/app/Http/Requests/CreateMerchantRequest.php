<?php

namespace Modules\Merchant\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Modules\Merchant\Dto\CreateMerchantDto;

class CreateMerchantRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'cover_photo' => ['required', 'mimes:png,jpg'],
            'profile_photo' => ['required', 'mimes:png,jpg'],
            'name' => ['required', 'string'],
            'meta_data' => ['required', 'array'],
            'meta_data.store_name' => ['string'],
            'meta_data.address_one' => ['string'],
            'meta_data.address_two' => ['string'],
            'meta_data.barangay' => ['required', 'string'],
            'meta_data.city' => ['required', 'string'],
            'meta_data.province' => ['required', 'string'],
            'meta_data.region' => ['required', 'string'],
            'meta_data.zip' => ['required', 'integer'],
            'meta_data.store_phone' => ['required', 'string'],
            'user_id' => ['required', Rule::unique('merchants', 'user_id')]
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('meta_data')) {
            $this->merge([
                'meta_data' => json_decode($this->input('meta_data'), true),
            ]);
        }


        $this->merge([
            'user_id' => $this->user()?->id,
        ]);
    }

    public function toDto(): CreateMerchantDto
    {
        return CreateMerchantDto::fromArray($this->validated());
    }
}
