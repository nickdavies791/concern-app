<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Imports\StaffImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaffImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_import_staff_details()
    {
        $this->signIn();

        Excel::fake();
        //Use test file to submit to store method
        
        $file = UploadedFile::fake()->create('staff.xlsx');

        //Submit the test file
        $this->post('staff/import', ['staff-import' => $file]);

        //Assert the data was processed properly
        Excel::assertImported('staff.xlsx', function (StaffImport $import) {
            return true;
        });
    }

    /** @test */
    public function a_guest_cannot_import_staff_details()
    {
        //Use test file to submit to store method
        $file = UploadedFile::fake()->create('staff.xlsx');

        //Submit the test file
        $this->post('staff/import', ['staff-import' => $file])
            ->assertRedirect('login');
    }
}
