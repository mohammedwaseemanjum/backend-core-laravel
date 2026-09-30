<?php

namespace Modules\Merchant\Actions;

use Illuminate\Http\Request;
use Modules\Merchant\Models\Merchant;

class DeleteMerchant
{
    public function handle(Request $request)
    {
        $merchant = Merchant::query()->firstWhere('user_id', $request->user()->id);
        $merchant->delete();
        $merchant->media()->delete();
    }
}
