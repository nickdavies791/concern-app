<?php

namespace App\Services\Interfaces;

interface MISInterface
{
    /**
     * Return the school details.
     *
     * @return mixed
     */
    public function getSchoolDetails();

    /**
     * Return the students.
     *
     * @return mixed
     */
    public function getStudents();

    /**
     * Return the staff members.
     *
     * @return mixed
     */
    public function getStaffMembers();

    /**
     * Return the attendance for students.
     *
     * @return mixed
     */
    public function getAttendance();

    /**
     * Return the exclusions for students.
     *
     * @return mixed
     */
    public function getExclusions();
}