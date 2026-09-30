<?php

namespace App\Services\Upload\UploaderFactory;

use App\Services\Upload\UploaderInterface;
use InvalidArgumentException;

class UploaderFactory
{
    static function make(): UploaderInterface
    {
        $type = config('app.storage.driver');

        return match ($type) {
            'cloudinary' => new CloudinaryFactory(),
            default  => throw new InvalidArgumentException("Unsupported uploader: {$type}"),
        };
    }
}
