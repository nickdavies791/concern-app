<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exports\StudentExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_download_student_export()
    {
        $this->signIn();

        Excel::fake();

        $this->get('students/export');

        Excel::assertDownloaded('students.xlsx', function (StudentExport $export) {
            return true;
        });
    }
}
