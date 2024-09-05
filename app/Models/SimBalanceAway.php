<?php

namespace App\Models;

use App\Observers\SimBalanceAwayObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy(SimBalanceAwayObserver::class)]
class SimBalanceAway extends Model
{
    protected $fillable = [
        "amount",
        "iccid",
        "comment",
    ];

    public function sim(): BelongsTo
    {
        return $this->belongsTo(Sim::class, "iccid", "iccid");
    }


}
