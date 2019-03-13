<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exports\GroupExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GroupExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_download_staff_export()
    {
        $this->signIn();

        Excel::fake();

        $this->get('group/export');

        Excel::assertDownloaded('groups.xlsx', function (GroupExport $export) {
            return true;
        });
    }
}
