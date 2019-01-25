<?php

namespace App;

use App\Repositories\Assembly;
use Illuminate\Database\Eloquent\Model;
use GregoryDuckworth\Encryptable\EncryptableTrait;
use Illuminate\Support\Facades\Storage;
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
        $response = (new Assembly())->getStudents();

        $students = json_decode($response);

        foreach ($students->data as $student) {
            $data[$student->id] = [
                'mis_id' => $student->mis_id,
                'admission_number' => $student->pan,
                'upn' => $student->upn,
                'forename' => $student->first_name,
                'surname' => $student->last_name,
                'year_group' => $student->year_code,
                'birth_date' => $student->dob,
                'sen_category' => $student->demographics->sen_category,
                'photo' => $student->photo
            ];
        }
        return json_decode(json_encode($data), FALSE);
    }

    public function updateStudentRecords(){
        foreach ($this->getSimsData() as $student) {
            try {
                $this->updateOrCreate(['mis_id' => $student->mis_id],
                    [
                        'mis_id' => $student->mis_id,
                        'admission_number' => $student->admission_number,
                        'upn' => $student->upn,
                        'forename' => $student->forename,
                        'surname' => $student->surname,
                        'year_group' => $student->year_group,
                        'birth_date' => $student->birth_date,
                        'sen_category' => $student->sen_category,
                        'photo_hash' => $student->photo->hash ?? null,
                ]);
                $existing = $this->whereMisId($student->mis_id)->first();
                $photo = $student->photo->hash ?? null;

                if ($existing->photo_hash !== $photo) {
                    if ($photo !== null) {
                        $image = $student->photo->url;
                        $contents = file_get_contents($image);
                        Storage::disk('students')->put($student->mis_id.'.jpg', $contents);
                    }
                }
            } catch (\Exception $e) {
                dd($e);
            }
        }
    }

    public function getFullNameAttribute()
    {
        return "{$this->forename} {$this->surname}";
    }
}
