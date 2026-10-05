<?php
namespace App\Services\upload;

interface UploaderInterface
{
    public function upload(mixed $file, string $folder);
    public function delete(mixed $properties);
}
