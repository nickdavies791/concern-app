<?php

namespace App\Http\Controllers;

use App\Group;
use App\Student;
use App\Concern;
use App\Events\ConcernCreated;
use App\Http\Requests\ConcernRequest;
use Carbon\Carbon;

class ConcernController extends Controller
{
	protected $concern;
	protected $group;
	protected $student;
	protected $image;

	/**
	 * ConcernController constructor.
	 * @param Concern $concern
	 * @param Group $group
	 * @param Student $student
	 */
	public function __construct(Concern $concern, Group $group, Student $student)
	{
		$this->concern = $concern;
		$this->group = $group;
		$this->student = $student;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		if (auth()->user()->cannot('view-all', $this->concern)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to this page.'
			]);
		}
		$concerns = $this->concern->with([
			'user:id,name',
			'students:student_id,forename,surname,year_group',
		])->latest()->simplePaginate(5);

		return view('concerns.index')
			->with(['concerns' => $concerns]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (auth()->user()->cannot('create', $this->concern)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to this page.'
			]);
		}

		return view('concerns.create')->with([
			'groups'   => $this->group->all(),
			'students' => $this->student->all()
		]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param ConcernRequest $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(ConcernRequest $request)
	{
		if (auth()->user()->cannot('create', $this->concern)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to this page.'
			]);
		}

		$concern = $this->concern->create([
			'user_id'      => $request->user_id,
			'type'         => $request->type,
			'body'         => $request->body,
			'concern_date' => $request->concern_date,
		]);

		if ($request->hasFile('files')) {
			$concern->saveFiles($request->file('files'), $concern);
		}
		if ($request->has('image')) {
			$concern->saveBodyMap($request->image, $concern);
		}

		// Sorts relationships and notifies selected groups
		event(new ConcernCreated($concern, $request));

		return redirect()
			->route('concerns.show', ['id' => $concern->id])
			->with('alert.success', 'Your concern has been saved.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param Concern $concern
	 * @return void
	 */
	public function show(Concern $concern)
	{
		if (auth()->user()->cannot('view', $concern)) {
			return back()->with([
				'alert.danger', 'You do not have access to view this concern.'
			]);
		}

		$concern = $this->concern->with([
			'user:id,name',
			'students:student_id,forename,surname,year_group',
			'attachments',
			'comments' => function ($query) {
				$query->orderBy('created_at', 'desc');
			}
		])->find($concern->id);

		return view('concerns.show')->with([
			'concern' => $concern
		]);
	}

	/**
	 * Display the form for editing the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit($id)
	{
		$concern = $this->concern->findOrFail($id);

		if (auth()->user()->cannot('update', $concern)) {
			return back()->with([
				'alert.danger', 'You do not have access to edit this concern.'
			]);
		}

		return view('concerns.edit')->with([
			'concern' => $concern
		]);
	}


	/**
	 * Update the specified resource.
	 *
	 * @param Request $request
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, $id)
	{
		$concern = $this->concern->findOrFail($id);

		if (auth()->user()->cannot('update', $concern)) {
			return back()->with([
				'alert.danger', 'You do not have access to edit this concern.'
			]);
		}

		if ($request->resolved) {
			$concern->resolved_on = Carbon::now();
		} else {
			$concern->resolved_on = null;
		}
		$concern->body = $request->body;
		$concern->save();

		return redirect('concerns.show')->with([
			'id' => $id,
			'alert.success', 'Your concern has been updated.'
		]);
	}

	/**
	 * Soft delete the specified resource.
	 *
	 * @param Concern $concern
	 * @return \Illuminate\Http\RedirectResponse
	 * @throws \Exception
	 */
	public function delete(Concern $concern)
	{
		if (auth()->user()->cannot('delete', $concern)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to delete this concern.'
			]);
		}

		$concern->delete();

		return redirect('home')->with([
			'alert.success', 'The specified concern was deleted'
		]);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param Concern $id
	 * @return void
	 */
	public function destroy(Concern $id)
	{
		if (auth()->user()->cannot('destroy', $this->concern)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to delete this concern.'
			]);
		}

		$this->concern->destroy($id);
	}
}
