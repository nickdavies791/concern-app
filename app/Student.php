<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\Assembly;
use GregoryDuckworth\Encryptable\EncryptableTrait;

class Student extends Model
{
    use EncryptableTrait;

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
    * Retrieves the concerns about a particular student.
    */
    public function concerns(){
        return $this->belongsToMany(Concern::class);
    }

    /**
     * gets student data from sims api and formats it appropriately
     * @return array
     */
    public function getSimsData(){
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
}
