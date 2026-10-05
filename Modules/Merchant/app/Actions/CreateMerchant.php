<?php

namespace Modules\Merchant\Actions;

use Modules\Merchant\Models\Merchant;

class CreateMerchant
{
    public function handle(mixed $request): Merchant
    {
        $dto = collect($request->toDto())->toArray();
        dd(Merchant::create($dto));
        return Merchant::create($dto);
    }
}
