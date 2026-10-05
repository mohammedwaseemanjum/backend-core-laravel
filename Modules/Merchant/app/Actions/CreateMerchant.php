<?php

namespace Modules\Merchant\Actions;

use Modules\Merchant\Models\Merchant;

class CreateMerchant
{
    public function handle(mixed $request): Merchant
    {
        $dto = collect($request->toDto())->toArray();
        $merchant = Merchant::create($dto);
        $merchant->refresh();
        dd($merchant);
    }
}
