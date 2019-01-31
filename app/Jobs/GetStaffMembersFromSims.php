<?php

namespace App\Jobs;

use App\Repositories\Assembly;
use Illuminate\Bus\Queueable;
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
        $response = (new Assembly())->getStaffMembers();

        $staffMembers = json_decode($response);

        foreach ($staffMembers->data as $staff) {
            $data[$staff->id] = [
                'code' => $staff->staff_code,
                'email' => strtolower($staff->first_name .'.'. $staff->last_name.config('app.mail_domain')),
                'name' => $staff->first_name .' '. $staff->last_name
            ];
        }

        $sync = json_decode(json_encode($data), FALSE);
        dispatch(new SyncStaffMembers($sync));
    }
}
