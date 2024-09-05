<?php

namespace App\Action\BalanceTransfer;

use App\Http\Requests\BalanceTransferRequest;
use App\Models\Sim;
use Illuminate\Support\Facades\DB;

class BalanceTransferAction
{
    private Sim $sim_from;
    private Sim $sim_to;
    private string $comment;
    private float $sum;

    public function __construct(BalanceTransferRequest $request)
    {
        $this->sim_from = $request->input("simid_from_model");
        $this->sim_to = $request->input("simid_to_model");
        $this->comment = $request->validated("comment");
        $this->sum = $request->validated("sum");
    }

    public function handle(): array
    {
        $transfer = new TransferAction(from: $this->sim_from, to: $this->sim_to, amount: $this->sum, comment: $this->comment);

        DB::transaction(function () use ($transfer) {
            $transfer->away()->come();
        });

        return [
            "simTo_balance" => $this->sim_to->refresh()->balance,
            "simFrom_balance" => $this->sim_from->refresh()->balance,
        ];
    }
}
