<?php

namespace App\Http\Controllers;

use App\Policy;
use App\Group;
use Illuminate\Http\Request;
use App\Http\Requests\PolicyRequest;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return auth()->user()->policies;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('policies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PolicyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyRequest $request, Policy $policy, Group $group)
    {
        $file = $request->file_path->storeAs('documents',
            $request->name .'.'. $request->file_path->getClientOriginalExtension(), 'public');

        $policy = $policy->create(['name' => $request->name, 'file_path' => $file]);

        foreach ($request->groups as $groupId) {
            foreach ($group->find($groupId)->users as $user) {
                try {
                    $user->policies()->attach($policy->id);
                } catch (\Exception $e) {
                    info("user already assigned to policy", ['errror' => $e]);
                }
            }
        }

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
        auth()->user()
        ->policies()
        ->updateExistingPivot($id, ['read_at' => now()]);

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
