<?php

namespace App\Repositories;

use App\Token;
use GuzzleHttp\Client;

class Assembly
{
	/**
	 * Gets the OAuth details from the Assembly API
	 * @param  string $code authorisation code
	 * @return object OAuth token details
	 */
	public function authorise($code)
	{
		$response = (new Client())->post(config('services.assembly.auth_uri'), [
			'form_params' => [
				'grant_type'    => 'authorization_code',
				'client_id'     => config('services.assembly.client_id'),
				'client_secret' => config('services.assembly.client_secret'),
				'redirect_uri'  => config('services.assembly.redirect_uri'),
				'code'          => $code,
			],
		]);

		return json_decode($response->getBody());
	}

	/**
	 * Refreshes access token in database
	 * @param Token $token
	 * @return boolean Success of refresh token
	 */
	protected function refreshToken(Token $token)
	{
		$response = (new Client())->post(config('services.assembly.auth_uri'), [
			'form_params' => [
				'grant_type'    => 'refresh_token',
				'client_id'     => config('services.assembly.client_id'),
				'client_secret' => config('services.assembly.client_secret'),
				'refresh_token' => $token->refresh_token,
			]
		]);

		$assembly = json_decode($response->getBody());

		$refreshedToken = $token->update([
			'secret' => $assembly->access_token
		]);

		return $refreshedToken ? true : false;
	}

	/**
	 * Configure the client to access SIMS API
	 * @return Client
	 */
	protected function configureClient()
	{
		$token = Token::first();

		if ($token->expires_in) {
			$this->refreshToken($token);
		}

		$client = new Client([
			'verify'  => false,
			'headers' => [
				'Accept'        => 'application/vnd.assembly+json; version=1',
				'Authorization' => 'Bearer ' . $token->secret
			]
		]);

		return $client;
	}

	/**
	 * Get school information from SIMS
	 * @return string
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getSchoolDetails()
	{
		$client = $this->configureClient();
		$response = $client->request('GET', config('services.assembly.endpoint') . '/school', [
			'form_params' => [
				'page'     => '1',
				'per_page' => '1500'
			]
		]);

		return json_decode($response->getBody()->getContents());
	}

	/**
	 * Get student data from SIMS for all students
	 * @return string
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getStudents()
	{
		$client = $this->configureClient();
		$response = $client->request('GET', config('services.assembly.endpoint') . '/students', [
			'form_params' => [
				'page'         => '1',
				'per_page'     => '1500',
				'demographics' => true,
				'ever_in_care' => true,
				'sen_needs'    => true,
				'photo'        => true,
			]
		]);

		$students = json_decode($response->getBody()->getContents());

		return $students->data;
	}

	/**
	 * Gets the staff data from sims for teaching staff
	 * @return object staff sims data
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getStaffMembers()
	{
		$client = $this->configureClient();
		$response = $client->request('GET', config('services.assembly.endpoint') . '/staff_members', [
			'form_params' => [
				'page'     => '1',
				'per_page' => '1500',
			]
		]);

		$staffMembers = json_decode($response->getBody()->getContents());

		return $this->formatStaffData($staffMembers->data);
	}

	/**
	* Returns a collection of staff data
	* @param object $exclusions
	* @return Illuminate\Support\Collection
	*/
	private function formatStaffData($staffMembers)
	{
		$staffMembersData = collect($staffMembers)->mapWithKeys(function($staffMember){
            return [$staffMember->id => (object)[
                'code' => $staffMember->staff_code,
                'name' => $staffMember->first_name .' '. $staffMember->last_name
            ]];
		});
		
		return $staffMembersData;
	}

	/**
	 * Gets the attendance summary data for students
	 * @return string
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getAttendance()
	{
		$client = $this->configureClient();
		
		$response = $client->request('GET', config('services.assembly.endpoint') . '/attendances/summaries', [
			'form_params' => [
				'page'     => '1',
				'per_page' => '1500',
			]
		]);

		$attendances = json_decode($response->getBody()->getContents());

		return $this->formatAttendanceData($attendances->data);
	}

	/**
	* Returns a collection of attendance data
	* @param object $exclusions
	* @return Illuminate\Support\Collection
	*/
	private function formatAttendanceData($attendances)
	{
		$attendanceData = collect($attendances)->mapWithKeys(function ($attendanceData) {
			return [
				$attendanceData->id => (object)[
					'id' => $attendanceData->id,
					'student_id' => $attendanceData->student_id,
					'start_date' => $attendanceData->start_date,
					'end_date' => $attendanceData->end_date,
					'possible_sessions' => $attendanceData->possible_sessions,
					'attended_sessions' => $attendanceData->attended_sessions,
					'late_sessions' => $attendanceData->late_sessions,
					'authorised_absence_sessions' => $attendanceData->authorised_absence_sessions,
					'unauthorised_absence_sessions' => $attendanceData->unauthorised_absence_sessions,
				]
			];
		});

		return $attendanceData;
	}

	/**
	 * Gets the exclusions data for students
	 * @return string
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 */
	public function getExclusions()
	{
		$client = $this->configureClient();
		$response = $client->request('GET', config('services.assembly.endpoint') . '/exclusions', [
			'form_params' => [
				'page'     => '1',
				'per_page' => '1500',
			]
		]);

		$exclusions = json_decode($response->getBody()->getContents());

		return $this->formatExclusions($exclusions->data);
	}

	/**
	 * Returns a collection of exclusions 
	 * @param object $exclusions
	 * @return Illuminate\Support\Collection
	 */
	private function formatExclusions($exclusions)
	{
		$exclusionsData = collect($exclusions)->mapWithKeys(function ($exclusion) {
			return [
				$exclusion->id => (object)[
					'id' => $exclusion->id,
					'student_id' => $exclusion->student_id,
					'type' => $exclusion->exclusion_type,
					'reason' => $exclusion->exclusion_reason,
					'start_date' => $exclusion->start_date,
					'start_session' => $exclusion->start_session,
					'end_date' => $exclusion->end_date,
					'end_session' => $exclusion->end_session,
					'length' => $exclusion->exclusion_length,
				]
			];
		});
		
		return $exclusionsData;
	}
}
