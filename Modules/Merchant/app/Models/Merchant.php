<?php

namespace Modules\Merchant\Models;

use App\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class Merchant extends Model
{
    use HasFactory;
    use HasUlids;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'meta_data',
        'user_id'
    ];

    protected $keyType = 'string';
    public $incrementing = false;

    protected function casts(): array
    {
        return [
            'meta_data' => 'array'
        ];
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'modelable');
    }
}
