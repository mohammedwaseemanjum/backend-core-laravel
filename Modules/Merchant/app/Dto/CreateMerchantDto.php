<?php

namespace Modules\Merchant\Dto;
use Illuminate\Http\UploadedFile;

class CreateMerchantDTO
{
    public function __construct(
        public readonly string $name,
        public readonly array $meta_data,
        public readonly UploadedFile $cover_photo,
        public readonly UploadedFile $profile_photo,
        public readonly int $user_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            cover_photo: $data['cover_photo'],
            profile_photo: $data['profile_photo'],
            name: $data['name'],
            meta_data: [
                'store_name' => $data['meta_data']['store_name'],
                'address_one' => $data['meta_data']['address_one'] ?? '',
                'address_two' => $data['meta_data']['address_two'] ?? '',
                'barangay' => $data['meta_data']['barangay'],
                'city' => $data['meta_data']['city'],
                'province' => $data['meta_data']['province'],
                'region' => $data['meta_data']['region'],
                'zip' => $data['meta_data']['zip'],
                'store_phone' => $data['meta_data']['store_phone'],
            ],
            user_id: $data['user_id']
        );
    }
}
