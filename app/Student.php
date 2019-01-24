<?php

namespace App;

use App\Repositories\Assembly;
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
    * gets student data from sims api and formats it appropriately
    * @return array
    */
    private function getSimsData(){
        $students = (new Assembly())->getStudents();

        foreach ($students as $student) {
            $data[$student->getId()] = [
                'admission_number' => $student->getPan(),
                'upn' => $student->getUpn(),
                'forename' => $student->getFirstName(),
                'surname' => $student->getLastName(),
                'year_group' => $student->getYearCode(),
                'birth_date' => date_format($student->getDob(), 'Y-m-d')
            ];
        }

        return json_decode(json_encode($data), FALSE);
    }

    public function updateStudentRecords(){
        foreach ($this->getSimsData() as $student) {
            try {
                $this->updateOrCreate(['admission_number' => $student->admission_number],
                    [
                    'admission_number' => $student->admission_number,
                    'upn' => $student->upn,
                    'forename' => $student->forename,
                    'surname' => $student->surname,
                    'year_group' => $student->year_group,
                    'birth_date' => $student->birth_date
                ]);
            } catch (\Exception $e) {
                return view('settings')->with('alert.danger', 'There was a problem syncing the data');
            }
        }
    }

    public function getFullNameAttribute()
    {
        return "{$this->forename} {$this->surname}";
    }
}
