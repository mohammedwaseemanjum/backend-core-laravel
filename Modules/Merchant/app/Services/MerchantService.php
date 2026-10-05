<?php

namespace Modules\Merchant\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\Actions\CreateMerchant;
use Modules\Merchant\Actions\DeleteMerchant;
use Modules\Merchant\Actions\UpdateMerchant;
use Modules\Merchant\Actions\UploadMerchantImage;
use Modules\Merchant\Http\Requests\CreateMerchantRequest;
use Modules\Merchant\Models\Merchant;
use Exception;

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
        // DB::transaction(function () use ($request) {
        //     $merchant = $this->createMerchant->handle($request);
        //     $this->uploadMerchantImage->uploadCoverPhoto($request, $merchant);
        //     $this->uploadMerchantImage->uploadProfilePhoto($request, $merchant);
        // });


            DB::beginTransaction();

            try {
                $merchant = $this->createMerchant->handle($request);
                $this->uploadMerchantImage->uploadCoverPhoto($request, $merchant);
                $this->uploadMerchantImage->uploadProfilePhoto($request, $merchant);

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
            }

            return Merchant::query()->with('media')->firstWhere('user_id', request()->user()->id);
    }

    public function update(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $merchant = $this->updateMerchant->handle($request);
            $this->uploadMerchantImage->updateCoverPhoto($request, $merchant);
            $this->uploadMerchantImage->updateProfilePhoto($request, $merchant);

            return $merchant;
        });
    }

    public function delete(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->uploadMerchantImage->deletePhotos($request);
            $this->deleteMerchant->handle($request);
        });
    }
}
