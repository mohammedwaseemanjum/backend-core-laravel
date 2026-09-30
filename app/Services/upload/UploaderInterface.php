<?php
namespace App\Services\Upload;

interface UploaderInterface
{
    public function upload(mixed $file, string $folder);
    public function delete(mixed $properties);
}
