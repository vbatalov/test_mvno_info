<?php

namespace App\Observers;

use App\Models\SimBalanceAway;

class SimBalanceAwayObserver
{
    /**
     * Handle the SimBalanceAway "created" event.
     */
    public function created(SimBalanceAway $simBalanceAway): void
    {
        $current_balance = $simBalanceAway->sim->balance;

        $simBalanceAway->sim->update([
            "balance" => $current_balance - $simBalanceAway->amount
        ]);

    }

    /**
     * Handle the SimBalanceAway "updated" event.
     */
    public function updated(SimBalanceAway $simBalanceAway): void
    {
        //
    }

    /**
     * Handle the SimBalanceAway "deleted" event.
     */
    public function deleted(SimBalanceAway $simBalanceAway): void
    {
        //
    }

    /**
     * Handle the SimBalanceAway "restored" event.
     */
    public function restored(SimBalanceAway $simBalanceAway): void
    {
        //
    }

    /**
     * Handle the SimBalanceAway "force deleted" event.
     */
    public function forceDeleted(SimBalanceAway $simBalanceAway): void
    {
        //
    }
}
