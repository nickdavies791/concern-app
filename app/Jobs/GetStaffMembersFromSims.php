<?php

namespace App\Jobs;

use App\User;
use Illuminate\Bus\Queueable;
use App\Repositories\Assembly;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetStaffMembersFromSims implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(Assembly $assembly, User $user)
    {
        $assembly->getStaffMembers()->each(function ($staff) use ($user) {
            try {
                $member = $user->updateOrCreate(
                    ['staff_code' => $staff->code],
                    [
                        'staff_code' => $staff->code,
                        'name' => $staff->name,
                    ]
                );

                if ($member->wasRecentlyCreated) {
                    $member->role_id = 1;
                    $member->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
                    $member->save();
                }
            } catch (\Exception $e) {
                info('Error: ', ['Error: ' => $e]);
            }
        });
    }
}
