<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
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
    * returns the users of a particular group
    */
    public function users(){
        return $this->belongsToMany(User::class);
    }

    /**
     * assigns users in groups to the uploaded policy
     * @param  array  $groups   array of group ids
     * @param  string $policyId id of policy uploaded
     * @return void
     */
    public function assignPolicies(array $groups, string $policyId){
        foreach ($groups as $groupId) {
            foreach ($this->find($groupId)->users as $user) {
                try {
                    $user->policies()->attach($policyId);
                } catch (\Exception $e) {
                    info("user already assigned to policy", ['errror' => $e]);
                }
            }
        }
    }

    /**
     * Assign users in groups to the selected document
     * @param array $groups
     * @param string $id
     */
    public function assignDocuments(array $groups, string $id){
        foreach ($groups as $group) {
            foreach ($this->find($group)->users as $user) {
                try {
                    $user->documents()->attach($id);
                } catch (\Exception $e) {
                    info("User already has this policy", ['error' => $e]);
                }
            }
        }
    }

}
