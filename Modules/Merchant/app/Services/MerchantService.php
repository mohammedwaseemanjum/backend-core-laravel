<?php

namespace Modules\Merchant\Services;

use Illuminate\Http\Request;
use Modules\Merchant\Actions\CreateMerchant;
use Modules\Merchant\Actions\DeleteMerchant;
use Modules\Merchant\Actions\UpdateMerchant;
use Modules\Merchant\Actions\UploadMerchantImage;
use Modules\Merchant\Http\Requests\CreateMerchantRequest;
use Modules\Merchant\Models\Merchant;

class MerchantService
{
    public function __construct(
        private CreateMerchant $createMerchant,
        private UpdateMerchant $updateMerchant,
        private DeleteMerchant $deleteMerchant,
        private UploadMerchantImage $uploadMerchantImage
    ) {}

    public function save(CreateMerchantRequest $request)
    {
        $merchant = $this->createMerchant->handle($request);
        $this->uploadMerchantImage->uploadCoverPhoto($request, $merchant);
        $this->uploadMerchantImage->uploadProfilePhoto($request, $merchant);

        return Merchant::query()->with('media')->firstWhere('user_id', request()->user()->id);
    }

    public function update(Request $request)
    {
        $merchant = $this->updateMerchant->handle($request);
        $this->uploadMerchantImage->updateCoverPhoto($request, $merchant);
        $this->uploadMerchantImage->updateProfilePhoto($request, $merchant);

        return $merchant;
    }

    public function delete(Request $request)
    {
        $this->uploadMerchantImage->deletePhotos($request);
        $this->deleteMerchant->handle($request);
    }
}
