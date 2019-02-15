<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Exclusion extends Model
{
    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
    * Disable created_at and updated_at fields.
    * @var boolean
    */
    public $timestamps = false;

    /**
     * Returns the student associated with an exclusion
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Return formatted start_date
     * @param $value
     * @return string
     */
    public function getStartDateAttribute($value)
    {
        return Carbon::parse($value)->format('d M y g:ia');
    }

    /**
     * Return formatted end_date
     * @param $value
     * @return string
     */
    public function getEndDateAttribute($value)
    {
        return Carbon::parse($value)->format('d M y g:ia');
    }

    /**
     * Store formatted start_date attribute
     * @param $value
     * @return string
     */
    public function setStartDateAttribute($value)
    {
        return $this->attributes['start_date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }

    /**
     * Store formatted end_date attribute
     * @param $value
     * @return string
     */
    public function setEndDateAttribute($value)
    {
        return $this->attributes['end_date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
    }
}
