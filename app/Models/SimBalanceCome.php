<?php

namespace App\Models;

use App\Observers\SimBalanceComeObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(SimBalanceComeObserver::class)]
class SimBalanceCome extends Model
{
    protected $fillable = [
        "amount",
        "iccid",
        "comment",
    ];

    public function sim()
    {
        return $this->belongsTo(Sim::class, "iccid", "iccid");
    }

}
