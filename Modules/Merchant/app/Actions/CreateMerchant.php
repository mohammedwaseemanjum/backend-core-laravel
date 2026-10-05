<?php

namespace Modules\Merchant\Actions;

use Modules\Merchant\Models\Merchant;
use Illuminate\Support\Facades\DB;

class CreateMerchant
{
    public function handle(mixed $request): Merchant
    {
        return DB::transaction(function () use ($request) {
            $dto = collect($request->toDto())->toArray();
            return Merchant::create($dto);
        });
    }
}
