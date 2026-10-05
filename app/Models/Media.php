<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'name',
        'custom_properties',
        'file_name',
        'collection'
    ];

    protected $table = 'medias';

    protected function casts(): array
    {
        return [
            'custom_properties' => 'array'
        ];
    }
}
