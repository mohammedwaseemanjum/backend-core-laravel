<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

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

    public function modelable(): MorphTo
    {
        return $this->morphTo();
    }
}
