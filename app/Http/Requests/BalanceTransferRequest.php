<?php

namespace App\Http\Requests;

use App\Action\BalanceTransfer\SimIdSearchEngine;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class BalanceTransferRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            "simid_from" => [
                "required", "integer", "min_digits:6",
            ],
            "simid_to" => [
                "required", "integer", "min_digits:6",
            ],
            "sum" => [
                "required", "decimal:2,10",
            ],
            "comment" => [
                "required", "string"
            ]
        ];
    }

    protected function passedValidation(): void
    {
        $from_model = SimIdSearchEngine::searchByIccid($this->validated("simid_from"));
        $to_model = SimIdSearchEngine::searchByIccid($this->validated("simid_to"));

        if ($from_model->iccid == $to_model->iccid) {
            throw ValidationException::withMessages([
                "message" => "Получатель и отправитель не может быть одинаковым",
            ]);
        }

        $this->merge([
            "simid_from_model" => $from_model,
            "simid_to_model" => $to_model,
        ]);
    }
}
