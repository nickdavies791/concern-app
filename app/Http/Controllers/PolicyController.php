<?php

namespace App\Http\Controllers;

use App\Group;
use App\Policy;
use Illuminate\Http\Request;
use App\Http\Requests\PolicyRequest;

class PolicyController extends Controller
{
    /**
     * Returns policies associated with logged in user.
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->policies;
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('policies.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  \App\Http\Requests\PolicyRequest  $request
     * @param  \App\Policy $policy
     * @param  \App\Group $group
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyRequest $request, Policy $policy, Group $group)
    {
        //store attached policy
        $file = $request->file_path->storeAs('documents',
            $request->name .'.'. $request->file_path->getClientOriginalExtension(),
        'public');

        //create a db record
        $policy = $policy->create(['name' => $request->name, 'file_path' => $file]);

        //assign policies to the selected groups
        $group->assignPolicies($request->groups, $policy->id);

        alert()->success('Success!', 'Policy has been uploaded successfully')->showConfirmButton('Got it!');
        return redirect('settings');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //mark as read
        auth()->user()
        ->policies()
        ->updateExistingPivot($id, ['read_at' => now()]);

        //return policy sotrage location for the front end
        $policy = Policy::where('id', '=', $id)->first();
        return asset('storage/'. $policy->file_path);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

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