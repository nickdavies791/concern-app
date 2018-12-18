<?php

namespace App;

use Laravel\Scout\Searchable;
use App\Repositories\Assembly;
use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;

class Student extends Model
{
    use EncryptableTrait, Searchable;

    /**
	 * Encrypted fields
	 * @var array
	 */
	protected $encryptable = [
		'forename',
		'surname',
        'upn',
        'admission_number'
	];

    /**
    * The attributes that are not mass assignable.
    * @var array
    */
    protected $guarded = [];

    /**
     * Get the indexable data array for the model - Algolia/Scout.
     * @return array
     */
    public function toSearchableArray(){
        return [
            'id' => $this->id,
            'forename' => $this->forename,
            'surname' => $this->surname,
            'year_group' => $this->year_group
        ];
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
                $this->updateOrCreate(['admission_number' => $student->admission_number],[
                    'admission_number' => $student->admission_number,
                    'upn' => $student->upn,
                    'forename' => $student->forename,
                    'surname' => $student->surname,
                    'year_group' => $student->year_group,
                    'birth_date' => $student->birth_date
                ]);
            } catch (\Exception $e) {
                info(['student not added' => ['data' => $data, 'error' => $e]]);
            }
        }
    }
}
