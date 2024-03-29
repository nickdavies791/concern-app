<?php

namespace App\Http\Controllers;

use App\Jobs\GetSchoolDetails;
use App\Services\Interfaces\MISInterface;
use App\Token;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * The MISInterface implementation.
     *
     * @var MISInterface
     */
    protected $mis;

    /**
     * TokenController constructor.
     * @param MISInterface $mis
     */
    public function __construct(MISInterface $mis)
    {
        $this->mis = $mis;
    }

    /**
	 * Show the form for creating a new resource.
	 * @param  \App\Token $token
	 * @return \Illuminate\Http\Response
	 */
	public function create(Token $token)
	{
		$query = http_build_query([
			'redirect_uri'  => config('services.assembly.redirect_uri'),
			'client_id'     => config('services.assembly.client_id'),
			'response_type' => 'code',
			'scope'         => config('services.assembly.scopes'),
			'state'         => csrf_token()
		]);

		// Token already exists, needs refreshing not authorising
		if ($token->first()) {
			return redirect('settings')->with('alert.warning', 'Your application is already authorised');
		}

		return redirect('https://platform.assembly.education/oauth/authorize?' . $query);
	}

	/**
	 * Stores OAuth token in the database.
	 * @param  \Illuminate\Http\Request $request
	 * @param  \App\Token $token
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, Token $token)
	{
		abort_unless($request->state == csrf_token(), 403);

		//returns api oauth details i.e token, refresh-token
		$assembly = $token->authorise($this->mis, $request->code);

		$token->create([
			'secret'        => $assembly->access_token,
			'refresh_token' => $assembly->refresh_token,
			'scopes'        => implode(" ,", $assembly->scopes),
			'expires_in'    => $assembly->expires_in
		]);

		$this->dispatch(new GetSchoolDetails());

		return redirect('/settings')->with('alert.success', 'Successfully authorised with SIMS! You can now sync your data');
	}
}
