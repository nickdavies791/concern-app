<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Imports\StudentImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_import_student_details()
    {
        $this->signIn();

        Excel::fake();
        //Use test file to submit to store method

        $file = UploadedFile::fake()->create('students.xlsx');

        //Submit the test file
        $this->post('students/import', ['student-import' => $file]);

        //Assert the data was processed properly
        Excel::assertImported('students.xlsx', function (StudentImport $import) {
            return true;
        });
    }

    /** @test */
    public function a_guest_cannot_import_student_details()
    {
        //Use test file to submit to store method
        $file = UploadedFile::fake()->create('students.xlsx');

        //Submit the test file
        $this->post('students/import', ['student-import' => $file])
            ->assertRedirect('login');
    }
}
