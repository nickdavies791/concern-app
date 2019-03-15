<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Imports\TagImport;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagImportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_import_tag_details()
    {
        $this->signIn();

        Excel::fake();
        //Use test file to submit to store method

        $file = UploadedFile::fake()->create('tags.xlsx');

        //Submit the test file
        $this->post('tag/import', ['tag-import' => $file]);

        //Assert the data was processed properly
        Excel::assertImported('tags.xlsx', function (TagImport $import) {
            return true;
        });
    }

    /** @test */
    public function a_guest_cannot_import_tag_details()
    {
        //Use test file to submit to store method
        $file = UploadedFile::fake()->create('tags.xlsx');

        //Submit the test file
        $this->post('tag/import', ['tag-import' => $file])
            ->assertRedirect('login');
    }
}
