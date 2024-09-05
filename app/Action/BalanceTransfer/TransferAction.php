<?php

namespace App\Action\BalanceTransfer;

use App\Models\Sim;
use App\Models\SimBalanceAway;
use App\Models\SimBalanceCome;

class TransferAction
{
    public function __construct(public Sim $from, public Sim $to, public float $amount, public string $comment)
    {
    }

    public function come(): static
    {
        SimBalanceCome::create([
            "amount" => $this->amount,
            "iccid" => $this->to->iccid,
            "comment" => $this->comment
        ]);

        return $this;
    }

    public function away(): static
    {
        $this->check_min_balance();

        SimBalanceAway::create([
            "amount" => $this->amount,
            "iccid" => $this->from->iccid,
            "comment" => $this->comment
        ]);

        return $this;

    }

    private function check_min_balance(): void
    {
        $min_balance = $this->from->subscriber->min_balance;
        $current_balance = $this->from->balance;

        $balance_after_transfer = $current_balance - $this->amount;

        if ($balance_after_transfer < $min_balance) {
            abort('422', "Баланс после перемещения не может быть ниже: ($min_balance). Попытка сделать баланс $balance_after_transfer");
        }
    }
}
