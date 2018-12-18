<?php

namespace App\Http\Controllers;

use App\Concern;
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function concerns(){
        $concerns = auth()->user()->concerns()->with([
            'user:id,name',
            'students:student_id,forename,surname,year_group',
        ])->simplePaginate(5);

        return view('users.concerns', ['concerns' => $concerns]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $recordsUpdated = $user->updateStaffRecords();

        if(!$recordsUpdated){
            alert()->warning('Oops!', 'The staff data has not been updated, Please try again')->showConfirmButton('Got it!');
        }

        alert()->success('Success!', 'The staff data has been updated correctly');
        return redirect('settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
