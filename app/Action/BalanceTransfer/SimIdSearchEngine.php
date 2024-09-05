<?php

namespace App\Action\BalanceTransfer;

use App\Models\Sim;

class SimIdSearchEngine
{

    static public function searchByIccid(int $iccid): Sim
    {
        $sim = Sim::whereRaw("SUBSTR(iccid, -6) = ?", "$iccid")
            ->get()->first();

        if (!$sim) {
            abort(404, "Sim not found by iccid: $iccid");
        }

        return $sim;
    }
}
