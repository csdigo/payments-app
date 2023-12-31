<?php

namespace App\Http\Requests;

use App\Http\Traits\CsvParser;
use App\Models\Payment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

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
        return [
            '*.name' => 'required',
            '*.governmentId' => 'required',
            '*.email' => ['required', 'string'],
            '*.debtAmount' => ['required', 'string'],
            '*.debtDueDate' => ['required', 'date'],
            '*.debtId' => ['required', 'integer'],
        ];
    }

    public function Valid()
    {
        $file = $this->file("file")->get();

        $csvData = CsvParser::CsvToArray($file);
        $validator = Validator::make(
            $csvData,
            $this->rules()
        );

        if ($validator->fails()) {
            return $validator->errors();
        }
    }
}