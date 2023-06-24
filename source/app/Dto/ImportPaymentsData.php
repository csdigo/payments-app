<?php

namespace App\Dto;
use App\Http\Requests\ImportPaymentsRequest;
use App\Http\Traits\CsvParser;

class ImportPaymentsData
{
    public $name;
    public $governmentId;
    public $email;
    public $debtAmount;
    public $debtDueDate;
    public $debtId;

    public static function fromRequest(ImportPaymentsRequest $request): array
    {
        $file = $request->file("file")->get();

        $csvData = CsvParser::CsvToArray($file);
        $import = [];

        $data = $request->validated();
        foreach ($csvData as $row) {
            $ret = new self();
            $ret->debtId = $row['debtId'];
            $ret->name = $row['name'];
            $ret->governmentId = $row['governmentId'];
            $ret->email = $row['email'];
            $ret->debtAmount = $row['debtAmount'];
            $ret->debtDueDate = $row['debtDueDate'];
            $import[] = $ret;
        }

        return $import;
    }
}