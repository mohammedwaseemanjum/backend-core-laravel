<?php

namespace App\Services\upload\UploaderFactory;

use App\Services\upload\UploaderInterface;
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
