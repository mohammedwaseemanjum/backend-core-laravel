<?php

namespace Modules\Merchant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MerchantController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadedFile = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
            'folder' => 'laravel_uploads',
        ]);

        $secureUrl = $uploadedFile['secure_url'];

        return response()->json([
            'url' => $secureUrl,
            'uploadedFile'=>$uploadedFile
        ]);
    }

    public function delete(Request $request)
    {

        cloudinary()->uploadApi()->destroy($request->id);

        return response()->json([
            'url' => 'yes'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id' => 'required'
        ]);

        cloudinary()->uploadApi()->destroy($request->id);

        $uploadedFile = Cloudinary::uploadApi()->upload($request->file('image')->getRealPath(), [
            'folder' => 'laravel_uploads',
        ]);

        $secureUrl = $uploadedFile['secure_url'];

        return response()->json([
            'url' => $secureUrl,
            'uploadedFile'=>$uploadedFile
        ]);
    }

}
