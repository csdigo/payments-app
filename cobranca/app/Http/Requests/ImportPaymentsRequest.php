<?php

namespace App\Http\Requests;

use App\Models\Cobranca;
use Illuminate\Foundation\Http\FormRequest;


class ImportPaymentsRequest extends FormRequest
{
    public function __construct()
    {
        
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        /*
        name,governmentId,email,debtAmount,debtDueDate,debtId
        John Doe,11111111111,johndoe@kanastra.com.br,1000000.00,2022-10-12,8291
        */
        return [
            'field_csvfile' => [
                'bail',
                'file',
                'mimes:csv,txt,xls,xlsx',
                new Cobranca( [
                    'name' => 'required',
                    'governmentId' => 'required', 'integer',
                    'email' => ['required', 'string'],
                    'debtAmount' => ['required', 'decimal'],
                    'debtDueDate' => ['required', 'date'],
                    'debtId' => ['required', 'integer'],
                ])
            ]
        ];
    }
}
