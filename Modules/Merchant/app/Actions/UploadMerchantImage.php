<?php

namespace Modules\Merchant\Actions;

use App\Services\upload\UploadService;
use Illuminate\Http\Request;
use Modules\Merchant\Http\Requests\CreateMerchantRequest;
use Modules\Merchant\Http\Requests\UpdateMerchantRequest;
use Modules\Merchant\Models\Merchant;

/*
Note: change the flow of uploaded images into
first upload it on the local so that if there is any database error the image will not be directly uploade into the cloud
second trigger a job if the database operation is succeed then after the image is being uploaded to the cloud delete the local image
*/

class UploadMerchantImage
{
    public function __construct(
        private UploadService $uploader,
    ) {}

    public function uploadCoverPhoto(CreateMerchantRequest $request, Merchant $merchant)
    {
        $upload = $this->uploader->upload($request->file('cover_photo')->getRealPath(), 'merchant_uploads/cover_photo');

        $merchant->media()->create([
            'name' => $upload['display_name'],
            'file_name' => $upload['display_name'] . '.' . $upload['format'],
            'collection' => 'merchant_uploads/cover_photo',
            'custom_properties' => [
                'version' => $upload['version']
            ]
        ]);
    }

    public function uploadProfilePhoto(CreateMerchantRequest $request, Merchant $merchant)
    {
        $upload = $this->uploader->upload($request->file('profile_photo')->getRealPath(), 'merchant_uploads/profile_photo');

        $merchant->media()->create([
            'name' => $upload['display_name'],
            'file_name' => $upload['display_name'] . '.' . $upload['format'],
            'collection' => 'merchant_uploads/profile_photo',
            'custom_properties' => [
                'version' => $upload['version']
            ]
        ]);
    }

    public function updateCoverPhoto(UpdateMerchantRequest $request, Merchant $merchant)
    {
        if (!$request->has('cover_photo')) return;

        $media = $merchant->media->firstWhere('collection', 'merchant_uploads/cover_photo');
        $this->uploader->delete('merchant_uploads/cover_photo/'.$media->name);

        $upload = $this->uploader->upload($request->file('cover_photo')->getRealPath(), 'merchant_uploads/cover_photo');

        $merchant->media()->update([
            'name' => $upload['display_name'],
            'file_name' => $upload['display_name'] . '.' . $upload['format'],
            'collection' => 'merchant_uploads/cover_photo',
            'custom_properties' => [
                'version' => $upload['version']
            ]
        ]);
    }

    public function updateProfilePhoto(UpdateMerchantRequest $request, Merchant $merchant)
    {
        if (!$request->has('profile_photo')) return;

        $media = $merchant->media->firstWhere('collection', 'merchant_uploads/profile_photo');
        $this->uploader->delete('merchant_uploads/profile_photo/'.$media->name);

        $upload = $this->uploader->upload($request->file('profile_photo')->getRealPath(), 'merchant_uploads/profile_photo');

        $merchant->media()->update([
            'name' => $upload['display_name'],
            'file_name' => $upload['display_name'] . '.' . $upload['format'],
            'collection' => 'merchant_uploads/profile_photo',
            'custom_properties' => [
                'version' => $upload['version']
            ]
        ]);
    }

    public function deletePhotos(Request $request)
    {
        $merchant = Merchant::query()->firstWhere('user_id', $request->user()->id);
        $merchant->media->map(function ($media) {
            $this->uploader->delete($media->collection.'/'.$media->name);
        });
    }
}
