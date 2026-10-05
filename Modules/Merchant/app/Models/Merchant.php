<?php

namespace Modules\Merchant\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Merchant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'meta_data',
        'user_id'
    ];

    protected function casts(): array
    {
        return [
            'meta_data' => 'array'
        ];
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'moduleable');
    }
}
