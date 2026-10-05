<?php

namespace App\Services\upload\UploaderFactory;

use App\Services\upload\UploaderInterface;

class CloudinaryFactory implements UploaderInterface
{
    public function upload(mixed $file, string $folder)
    {
        $uploadedFile = cloudinary()->uploadApi()->upload($file, [
            'folder' => $folder,
        ]);

        return $uploadedFile;
    }

    public function delete(mixed $properties)
    {
        cloudinary()->uploadApi()->destroy($properties);
    }
}
