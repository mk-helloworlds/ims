<?php

namespace App\Policies;

use App\Models\User;
use App\Models\internship_projects;
use Illuminate\Auth\Access\Response;

class InternshipProjectsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, internship_projects $internshipProjects): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, internship_projects $internshipProjects): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, internship_projects $internshipProjects): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, internship_projects $internshipProjects): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, internship_projects $internshipProjects): bool
    {
        //
    }
}
