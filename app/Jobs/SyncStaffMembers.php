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

    protected $staffMembers;

    /**
     * Create a new job instance.
     *
     * @param $data
     */
    public function __construct($staffMembers)
    {
        $this->staffMembers = $staffMembers;
    }

    /**
     * Execute the job.
     *
     * @param User $user
     * @return void
     */
    public function handle(User $user)
    {
        foreach ($this->staffMembers as $staffMember) {
            try {
                $member = $user->updateOrCreate(['staff_code' => $staffMember['code']],[
                    'staff_code' => $staffMember['code'],
                    'name' => $staffMember['name'],
                ]);

                if ($member->wasRecentlyCreated) {
                    $member->role_id = 1;
                    $member->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
                    $member->save();
                }
            } catch (\Exception $e) {
                Log::info('Error: ', ['Error: ' => $e]);
            }
        }
    }
}
