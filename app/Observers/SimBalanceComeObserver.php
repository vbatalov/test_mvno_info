<?php

namespace App\Observers;

use App\Models\SimBalanceCome;

class SimBalanceComeObserver
{
    /**
     * Handle the SimBalanceCome "created" event.
     */
    public function created(SimBalanceCome $simBalanceCome): void
    {
        $current_balance = $simBalanceCome->sim->balance;

        $simBalanceCome->sim->update([
            "balance" => $current_balance + $simBalanceCome->amount
        ]);
    }

    /**
     * Handle the SimBalanceCome "updated" event.
     */
    public function updated(SimBalanceCome $simBalanceCome): void
    {
        //
    }

    /**
     * Handle the SimBalanceCome "deleted" event.
     */
    public function deleted(SimBalanceCome $simBalanceCome): void
    {
        //
    }

    /**
     * Handle the SimBalanceCome "restored" event.
     */
    public function restored(SimBalanceCome $simBalanceCome): void
    {
        //
    }

    /**
     * Handle the SimBalanceCome "force deleted" event.
     */
    public function forceDeleted(SimBalanceCome $simBalanceCome): void
    {
        //
    }
}
