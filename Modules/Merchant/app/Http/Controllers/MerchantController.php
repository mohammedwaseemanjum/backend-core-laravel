<?php

namespace Modules\Merchant\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Media;
use App\Models\User;
use App\Services\Upload\UploadService;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\DB;
use Modules\Merchant\Actions\UploadMerchantImage;
use Modules\Merchant\Http\Requests\CreateMerchantRequest;
use Modules\Merchant\Http\Requests\UpdateMerchantRequest;
use Modules\Merchant\Models\Merchant;
use Modules\Merchant\Services\MerchantService;

class MerchantController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => Merchant::query()->with('media')->firstWhere('user_id', $request->user()->id)
        ]);
    }

    public function create(CreateMerchantRequest $request, MerchantService $merchantService) {
        return response()->json([
            'data' => $merchantService->save($request)
        ]);
    }

    public function update(UpdateMerchantRequest $request, MerchantService $merchantService)
    {
        return response()->json([
            'data' => $merchantService->update($request)
        ]);
    }

    public function delete(Request $request, MerchantService $merchantService)
    {
       $merchantService->delete($request);

        return response()->json([
            'message' => 'Delete merchant successfully'
        ]);
    }
}
