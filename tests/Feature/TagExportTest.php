<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Exports\TagExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagExportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_download_tag_export()
    {
        $this->signIn();

        Excel::fake();

        $this->get('tag/export');

        Excel::assertDownloaded('tags.xlsx', function (TagExport $export) {
            return true;
        });
    }
}
