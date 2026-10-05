<?php

namespace Modules\Merchant\Actions;

use Illuminate\Http\Request;
use Modules\Merchant\Models\Merchant;
use Illuminate\Support\Facades\DB;

class DeleteMerchant
{
    public function handle(Request $request)
    {
       DB::transaction(function () use ($request) {
            $merchant = Merchant::query()->firstWhere('user_id', $request->user()->id);
            $merchant->delete();
            $merchant->media()->delete();
       });
    }
}
