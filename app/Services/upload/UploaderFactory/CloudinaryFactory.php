<?php

namespace App\Services\Upload\UploaderFactory;

use App\Services\Upload\UploaderInterface;

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
