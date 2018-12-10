<?php

namespace App\Http\Controllers;

use App\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create(Token $token)
    {
        $query = http_build_query([
            'redirect_uri' => config('services.assembly.redirect_uri'),
            'client_id' => config('services.assembly.client_id'),
            'response_type' => 'code',
            'scope' => config('services.assembly.scopes'),
            'state' => csrf_token()
        ]);

        //Token already exists, needs refreshing not authorising
        if($token->first()){
            alert()->info('Hey!', 'Your application has already been authorised, you\'re all set to go')->showConfirmButton('Got it!');
            return redirect('settings');
        }
        return redirect('https://platform.assembly.education/oauth/authorize?'.$query);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request, Token $token)
    {
        abort_unless($request->state == csrf_token(), 403);

        //returns api oauth details i.e token, refresh-token
        $assembly = $token->authorise($request->code);

        $token->create([
            'secret' => $assembly->access_token,
            'refresh_token' => $assembly->refresh_token,
            'scopes' => implode(" ,", $assembly->scopes),
            'expires_in' => $assembly->expires_in
        ]);

        alert()->success('Sucess', 'Your application has now been authorised, you can now sync your data from SIMS')
        ->showConfirmButton('Got it!');
        return redirect('/settings');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Token  $token
    * @return \Illuminate\Http\Response
    */
    public function edit(Token $token)
    {
        //
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Token  $token
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Token $token)
    {
        //
    }
}
