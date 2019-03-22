<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exports\StaffExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StaffExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_download_staff_export()
    {
        $this->signIn();

        Excel::fake();

        $this->get('staff/export');

        Excel::assertDownloaded('users.xlsx', function (StaffExport $export) {
            return true;
        });
    }
}
