<?php

namespace App\Http\Controllers;

use App\Document;
use App\Group;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
	protected $document;
	protected $group;

	/**
	 * DocumentController constructor.
	 * @param Document $document
	 * @param Group $group
	 */
	public function __construct(Document $document, Group $group)
	{
		$this->document = $document;
		$this->group = $group;
	}

	public function all()
	{
		return auth()->user()->documents;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('documents.index')->with([
			'documents' => $this->document->all()
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		if (auth()->user()->cannot('create', $this->document)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to upload documents.'
			]);
		}

		return view('documents.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		if (auth()->user()->cannot('create', $this->document)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to upload documents.'
			]);
		}

		// Store the document in Storage
		$file = $request->file_path
			->storeAs('documents', $request->name . '.' . $request->file_path
					->getClientOriginalExtension(), 'public');

		// Create a new record in the Document table
		$document = $this->document->create([
			'name'      => $request->name,
			'file_path' => $file
		]);

		// Assign the document to the selected groups
		$this->group->assignDocuments($request->groups, $document->id);

		return redirect('documents')->with([
			'alert.success', 'Your document has been uploaded successfully!'
		]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		// Save document as read for user
		auth()->user()
			->documents()
			->updateExistingPivot($id, ['read_at' => now()]);
		// Get storage location for the front end
		$document = $this->document->where('id', '=', $id)->first();

		return asset('storage/' . $document->file_path);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		if (auth()->user()->cannot('delete', $this->document)) {
			return redirect('home')->with([
				'alert.danger', 'You do not have access to remove documents.'
			]);
		}

		$document = $this->document->where('id', '=', $id)->first();
		unlink(public_path("storage/" . $document->file_path));
		$document->delete();

		return redirect('documents.index');
	}
}
