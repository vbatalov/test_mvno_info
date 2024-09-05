<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sim extends Model
{
    public $incrementing = false;
    protected $primaryKey = "iccid";

    protected $fillable = [
        "iccid",
        "subscriber_id",
        "balance",
    ];

    public function subscriber(): BelongsTo
    {
        return $this->belongsTo(Subscriber::class, "subscriber_id", "id");
    }
}
