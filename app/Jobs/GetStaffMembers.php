<?php

namespace App\Jobs;

use App\Services\Interfaces\MISInterface;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class GetStaffMembers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @param MISInterface $mis
     * @param User $user
     * @return void
     */
    public function handle(MISInterface $mis, User $user)
    {
        $mis->getStaffMembers()->each(function ($staff) use ($user) {
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
