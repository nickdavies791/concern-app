<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Imports\GroupImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_import_group_details()
    {
        $this->signIn();

        Excel::fake();
        //Use test file to submit to store method

        $file = UploadedFile::fake()->create('groups.xlsx');

        //Submit the test file
        $this->post('group/import', [ 'group-import' => $file]);

        //Assert the data was processed properly
        Excel::assertImported('groups.xlsx', function (GroupImport $import) {
            return true;
        });
    }

    /** @test */
    public function a_guest_cannot_import_book_details()
    {
        //Use test file to submit to store method
        $file = UploadedFile::fake()->create('groups.xlsx');

        //Submit the test file
        $this->post('group/import', ['group-import' => $file])
            ->assertRedirect('login');
    }
}
