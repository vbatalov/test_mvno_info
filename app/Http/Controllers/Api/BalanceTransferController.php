<?php

namespace App\Http\Controllers\Api;

use App\Action\BalanceTransfer\BalanceTransferAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BalanceTransferRequest;
use Illuminate\Http\Request;

class BalanceTransferController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(BalanceTransferRequest $request, BalanceTransferAction $action)
    {
        return $action->handle();
    }
}
