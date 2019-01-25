<?php

namespace App;

use App\Repositories\Assembly;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'role_id', 'staff_code', 'name', 'email', 'password',
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Return the Role associated with a User
     */
    public function role(){
        return $this->belongsTo(Role::class);
    }

    /**
     * Returns documents associated with a user
     */
    public function documents(){
        return $this->belongsToMany(Document::class)->withPivot('read_at');
    }

    /**
    * returns the groups a user is associated with
    */
    public function groups(){
        return $this->belongsToMany(Group::class);
    }

    /**
    * returns the concerns a user is associated with
    */
    public function concerns(){
        return $this->hasMany(Concern::class);
    }

    /**
     * Check the User has the 'Admin' role type
     * @return bool
     */
    public function isAdmin(){
        return $this->role()->where('type', 'Admin')->exists();
    }

    /**
     * Check the User has the 'Safeguarding' role type
     * @return bool
     */
    public function isSafeguarding(){
        return $this->role()->where('type', 'Safeguarding')->exists();
    }

    /**
     * Check the User has the 'Staff' role type
     * @return bool
     */
    public function isStaff(){
        return $this->role()->where('type', 'Staff')->exists();
    }

    /**
     * Check the User has the 'User' role type
     * @return bool
     */
    public function isUser(){
        return $this->role()->where('type', 'User')->exists();
    }


    /**
     * Gets staff data from SIMS and formats
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function getSimsData(){
        $response = (new Assembly())->getStaffMembers();

        $staffMembers = json_decode($response);

        foreach ($staffMembers->data as $staff) {
            $data[$staff->id] = [
                'code' => $staff->staff_code,
                'email' => strtolower($staff->first_name .'.'. $staff->last_name.config('app.mail_domain')),
                'name' => $staff->first_name .' '. $staff->last_name
            ];
        }

        return json_decode(json_encode($data), FALSE);
    }

    /**
     * Import staff into database and set role and password
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateStaffRecords(){
        foreach ($this->getSimsData() as $staff) {
            try {
                $staffMember = $this->updateOrCreate(['staff_code' => $staff->code],[
                    'staff_code' => $staff->code,
                    'name' => $staff->name,
                    'email' => $staff->email
                ]);

                if($staffMember->wasRecentlyCreated){
                    $staffMember->role_id = 1;
                    $staffMember->password = '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm'; // secret
                    $staffMember->save();
                }
            } catch (\Exception $e) {
                return view('settings');
            }
        }
    }
}
