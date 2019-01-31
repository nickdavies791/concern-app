<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Student extends Model implements Searchable
{
    use EncryptableTrait;

     protected $appends = ['full_name'];

    /**
    * Encrypted fields
    * @var array
    */
    protected $encryptable = [
        'upn',
        'admission_number',
    ];

    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
     * Build search for students
     * @return SearchResult
     */
    public function getSearchResult(): SearchResult {
        $url = route('students.show', $this->id);
        $field = $this->full_name.' - Year '.$this->year_group;

        return new SearchResult(
            $this,
            $field,
            $url
        );
    }

    /**
    * Retrieves the concerns about a particular student.
    */
    public function concerns(){
        return $this->belongsToMany(Concern::class);
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
