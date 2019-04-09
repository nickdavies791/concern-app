<?php

namespace App;

use App\Repositories\Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Concern extends Model implements Searchable, HasMedia
{
	use EncryptableTrait;
	use SoftDeletes;
	use HasMediaTrait;

	/**
	 * Encrypted Fields
	 * @var array
	 */
	protected $encryptable = [
		'body'
	];

	/**
	 * The attributes that are not mass assignable.
	 * @var array
	 */
	protected $guarded = [];

	/**
	 * The attributes that are dates.
	 * @var array
	 */
	protected $dates = ['concern_date', 'created_at', 'updated_at', 'resolved_on', 'deleted_at'];

	/**
	 * Build search for students
	 * @return SearchResult
	 */
	public function getSearchResult(): SearchResult
	{
		$url = route('concerns.show', $this->id);

		return new SearchResult(
			$this,
			$this->type,
			$url
		);
	}

	/**
	 * Return the tags associated with a concern
	 */
	public function tags()
	{
		return $this->belongsToMany(Tag::class);
	}

	/**
	 * Return comments associated with a concern
	 */
	public function comments()
	{
		return $this->hasMany(Comment::class);
	}

	/**
	 * Return students associated with a concern
	 */
	public function students()
	{
		return $this->belongsToMany(Student::class);
	}

	/**
	 * Return groups associated with a concern
	 */
	public function groups()
	{
		return $this->belongsToMany(Group::class);
	}

	/**
	 * Return users associated with a concern
	 */
	public function user()
	{
		return $this->belongsTo(User::class);
	}

	/**
	 * Return attachments associated with a concern
	 */
	public function attachments()
	{
		return $this->hasMany(Attachment::class);
	}

	/**
	 * Return mutated created_at property
	 * @param $value
	 * @return mixed
	 */
	public function getCreatedAtAttribute($value)
	{
		return Carbon::parse($value)->format('d M Y g:ia');
	}

	/**
	 * Return the formatted concern_date attribute
	 * @param $value
	 * @return string
	 */
	public function getConcernDateAttribute($value)
	{
		return Carbon::parse($value)->format('d M Y g:ia');
	}

	/**
	 * Store formatted concern_date attribute
	 * @param $value
	 * @return string
	 */
	public function setConcernDateAttribute($value)
	{
		return $this->attributes['concern_date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
	}

    /**
     * Save requested attachments to media collection.
     *
     * @param array $media
     * @return \Illuminate\Http\Response
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\InvalidBase64Data
     */
    public function saveMedia(array $media)
    {
        $this->addAllMediaFromRequest()->each(function ($add) {
            $add->toMediaCollection('attachments');
        });
        if (!is_null('bodymap', $media)) {
            $this->addMediaFromBase64($media['bodymap'])
                ->usingFileName(Carbon::now()->format('Y-m-d_His').'_bodymap')
                ->toMediaCollection('attachments');
        }

        return response(200);
    }

	/**
	 * Updates the resolved_on attribute of a concern
	 * @param $current
	 * @return Carbon|null
	 */
	public function updateResolvedStatus($current)
	{
		$status = $current ? Carbon::now() : null;

		return $this->attributes['resolved_on'] = $status;
	}

	/**
	 * Return all unresolved concerns in latest order
	 * @param $query
	 * @return mixed
	 */
	public function scopeLatestUnresolved($query)
	{
		return $query->where('resolved_on', null)->latest();
	}

	/**
	 * Return all resolved concerns for last month
	 * @param $query
	 * @return mixed
	 */
	public function scopeResolvedLastMonth($query)
	{
		return $query->whereBetween('resolved_on', [Carbon::parse('first day of last month'), Carbon::parse('last day of last month')]);
	}

	/**
	 * Return all resolved concerns for this academic year
	 * @param $query
	 * @return mixed
	 */
	public function scopeResolvedThisAcademicYear($query)
	{
		$start = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->year, 9, 1);
		$end = Carbon::now();

		return $query->whereBetween('resolved_on', [$start, $end]);
	}

	/**
	 * Return all concerns reported this academic year
	 * @param $query
	 * @return mixed
	 */
	public function scopeReportedThisAcademicYear($query)
	{
		$start = Carbon::createMidnightDate(Carbon::now()->subMonths(8)->year, 9, 1);
		$end = Carbon::now();

		return $query->whereBetween('created_at', [$start, $end]);
	}

	/**
	 * Return all concerns reported last month
	 * @param $query
	 * @return mixed
	 */
	public function scopeReportedLastMonth($query)
	{
		return $query->where('created_at', Carbon::parse('first day of last month'));
	}
}
