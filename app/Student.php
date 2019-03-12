<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Student extends Model implements Searchable
{
	use EncryptableTrait;

	/**
	 * Encrypted fields
	 * @var array
	 */
	protected $encryptable = [
		'upn',
		'admission_number',
		'ever_in_care',
		'sen_category'
	];

	protected $appends = ['full_name'];

	/**
	 * The attributes that are not mass assignable.
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * Build search for students
	 * @return SearchResult
	 */
	public function getSearchResult(): SearchResult
	{
		$url = route('students.show', $this->id);
		$field = $this->full_name . ' - Year ' . $this->year_group;

		return new SearchResult(
			$this,
			$field,
			$url
		);
	}

	/**
	 * Returns the attendance summary for a student
	 */
	public function attendance()
	{
		return $this->hasOne(Attendance::class);
	}

	/**
	 * Returns the exclusions associated with a student
	 */
	public function exclusions()
	{
		return $this->hasMany(Exclusion::class);
	}

	/**
	 * Retrieves the siblings related to a student
	 */
	public function siblings()
	{
		return $this->belongsToMany(Student::class, 'sibling_student', 'sibling_id', 'student_id');
	}

	/**
	 * Retrieves the concerns about a particular student.
	 */
	public function concerns()
	{
		return $this->belongsToMany(Concern::class)->orderBy('created_at', 'DESC');
	}

	/**
	 * Returns the student forename and surname as full_name attribute
	 * @return string
	 */
	public function getFullNameAttribute()
	{
		return "{$this->forename} {$this->surname}";
	}
}
