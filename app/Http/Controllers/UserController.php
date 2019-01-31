<?php

namespace App\Http\Controllers;

use App\Concern;
use App\Jobs\GetStaffMembersFromSims;
use App\User;
use App\Repositories\Assembly;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    protected $concern;

    /**
     * UserController constructor.
     * @param User $user
     * @param Concern $concern
     */
    public function __construct(User $user, Concern $concern)
    {
        $this->user = $user;
        $this->concern = $concern;
    }

    /**
     * Return the concerns related to the authenticated user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function concerns(){
        if (auth()->user()->cannot('view-own', $this->concern)) {
            return redirect('home')->with('alert.danger', 'You do not have access to this page.');
        }
        $concerns = auth()->user()->concerns()->with([
            'user:id,name',
            'students:student_id,forename,surname,year_group',
        ])->simplePaginate(5);

        return view('users.concerns')->with(['concerns' => $concerns]);
    }

    /**
     * Dispatch job to get SIMS data and update staff records
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        $this->dispatch(new GetStaffMembersFromSims());
        return redirect('settings')->with('alert.warning', 'The staff data is currently syncing.');
    }
}
