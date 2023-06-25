<?php

namespace Tests\Feature;

use App\Models\Payment;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     */
    public function test_upload_file_correct(): void
    {

        Storage::fake('uploads');

        $header = 'name,governmentId,email,debtAmount,debtDueDate,debtId';
        $row1 = 'John Doe,333333,johndoe@kanastra.com.br,1000000.00,2024-10-12,8293';
        $row2 = 'Muniz,44444,johndoe@kanastra.com.br,100.50,2023-10-12,8294';

        $content = implode(PHP_EOL, [$header, $row1, $row2]);

        $inputs = [
            'file' =>
            UploadedFile::
                fake()->
                createWithContent(
                    'test.csv',
                    $content
                )
        ];


        $response = $this->post(
            '/api/file',
            $inputs

        );

        $retorno = Payment::get();
        $this->assertCount(2, $retorno);

        $response->assertStatus(201);
    }

    public function test_upload_file_incorrect(): void
    {
        Storage::fake('uploads');

        $header = 'name2,governmentId2,email,debtAmount2,debtDueDate2,debtId2';
        $row1 = 'John Doe,333333,johndoe@kanastra.com.br,1000000.00,2022-10-12,8293';
        $row2 = 'Muniz,44444,johndoe@kanastra.com.br,100.50,2023-10-12,8294';

        $content = implode(PHP_EOL, [$header, $row1, $row2]);

        $inputs = [
            'file' =>
            UploadedFile::
                fake()->
                createWithContent(
                    'test.csv',
                    $content
                )
        ];

        $response = $this->post(
            '/api/file',
            $inputs
        );

        $retorno = Payment::get();

        $this->assertCount(0, $retorno);

        $response->assertStatus(422);
    }
}