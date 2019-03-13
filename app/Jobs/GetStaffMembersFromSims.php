<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Jobs\SyncStaffMembers;
use App\Repositories\Assembly;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetStaffMembersFromSims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        $response = json_decode((new Assembly())->getStaffMembers());
        $staffMembers = collect($response->data);

        $data = $staffMembers->mapWithKeys(function($staffMember){
            return [$staffMember->id => [
                'code' => $staffMember->staff_code,
                'name' => $staffMember->first_name .' '. $staffMember->last_name
            ]];
        });

        dispatch(new SyncStaffMembers($data));
    }
}
