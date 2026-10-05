<?php

namespace Modules\Merchant\Actions;

use Modules\Merchant\Models\Merchant;
use Illuminate\Support\Facades\DB;
class UpdateMerchant
{
    public function handle(mixed $request)
    {
        DB::transaction(function () use ($request) {
            $user_id = $request->toDto()->user_id;
            $dto = collect($request->toDto())->toArray();
            $query = Merchant::query()->firstWhere('user_id', $user_id);

            return tap($query, fn ($merchant) => $merchant->update($dto));
        });
    }
}
