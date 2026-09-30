<?php

namespace Modules\Merchant\Dto;
use Illuminate\Http\UploadedFile;

class UpdateMerchantDTO
{
    public function __construct(
        public readonly string $name,
        public readonly array $meta_data,
        public readonly int $user_id,
        public readonly ?UploadedFile $cover_photo = null,
        public readonly ?UploadedFile $profile_photo = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            meta_data: [
                'store_name' => $data['meta_data']['store_name'],
                'address_one' => $data['meta_data']['address_one'],
                'address_two' => $data['meta_data']['address_two'],
                'country' => $data['meta_data']['country'],
                'town' => $data['meta_data']['town'],
                'state' => $data['meta_data']['state'],
                'zip' => $data['meta_data']['zip'],
                'store_phone' => $data['meta_data']['store_phone'],
            ],
            user_id: $data['user_id'],
            cover_photo: $data['cover_photo'] ?? null,
            profile_photo: $data['profile_photo'] ?? null,
        );
    }
}
