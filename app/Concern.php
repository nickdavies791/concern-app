<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;

class Concern extends Model
{
    use EncryptableTrait;

    /**
	 * Encrypted Fields
	 * @var array
	 */
	protected $encryptable = [
	    'title', 'body'
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
    protected $dates = ['concern_date', 'created_at', 'updated_at', 'resolved_on'];

    /**
    * return comments associated with a concern
    */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /**
    * return students associated with a concern
    */
    public function students(){
        return $this->belongsToMany(Student::class);
    }

    /**
    * return groups notified about a concern
    */
    public function groups(){
        return $this->belongsToMany(Group::class);
    }

    /**
    * return users associated with a concern
    */
    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Return the attachments associated with the concern
     */
    public function attachments(){
        return $this->hasMany(Attachment::class);
    }

    /**
     * Return mutated created_at property
     * @param $value
     * @return mixed
     */
    public function getReportedAtAttribute($value){
        return Carbon::parse($value)->format('d M Y g:ia');
    }

    /**
     * Return the formatted concern_date attribute
     * @param $value
     * @return string
     */
    public function getConcernDateAttribute($value){
        return Carbon::parse($value)->format('d M Y g:ia');
    }

    /**
     * Store formatted concern_date attribute
     * @param $value
     * @return string
     */
    public function setConcernDateAttribute($value){
        return $this->attributes['concern_date'] = Carbon::parse($value)->format('Y-m-d H:i:s');
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

}
