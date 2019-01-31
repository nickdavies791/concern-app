<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class SyncStaffMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param User $user
     * @return void
     */
    public function handle(User $user)
    {
        foreach ($this->data as $api) {
            try {
                $staffMember = $user->updateOrCreate(['staff_code' => $api->code],[
                    'staff_code' => $api->code,
                    'name' => $api->name,
                    'email' => $api->email
                ]);

                if ($staffMember->wasRecentlyCreated) {
                    $staffMember->role_id = 1;
                    $staffMember->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
                    $staffMember->save();
                }
            } catch (\Exception $e) {
                Log::info('Error: ', ['Error: ' => $e]);
            }
        }
    }
}
