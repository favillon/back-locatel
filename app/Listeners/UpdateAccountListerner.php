<?php

namespace App\Listeners;

use App\Events\BalanceAccountEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Enums\AccountTypeEnum;
use App\Models\Account;

class UpdateAccountListerner
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BalanceAccountEvent $event): void
    {
        $resultado = DB::table('transactions')
            ->select(DB::raw('SUM(value) as sum'))
            ->where('account_id', $event->infoAccount['account']->id)
            ->first();

        $account = Account::where([
            'user_id'         => $event->infoAccount['user']->id,
            'account_type_id' => AccountTypeEnum::SAVINGS
        ])->update(['balance' => $resultado->sum]);
        
        Log::info(
            'Update balance of User : ' . $event->infoAccount['user']->id .
            ' Name : ' . $event->infoAccount['user']->name .
            ' Account ID : ' . $event->infoAccount['account']->id .
            ' Number Account : ' .  $event->infoAccount['account']->account_number .
            ' New Balance : ' .  $resultado->sum
        );
    }
}
