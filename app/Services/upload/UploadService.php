<?php

namespace App\Services\Upload;

use App\Services\Upload\UploaderFactory\UploaderFactory;
use App\Services\Upload\UploaderInterface;

class UploadService implements UploaderInterface
{
    private UploaderInterface $uploader;

    public function __construct(UploaderFactory $uploader) {
        $this->uploader = $uploader::make();
    }

    public function upload(mixed $file, string $folder) {
        return $this->uploader->upload($file, $folder);
    }

    public function delete(mixed $properties) {
        $this->uploader->delete($properties);
    }
}
