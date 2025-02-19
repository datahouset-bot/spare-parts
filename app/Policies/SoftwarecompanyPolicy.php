<?php

namespace App\Policies;

use App\Models\User;
use App\Models\softwarecompany;
use Illuminate\Auth\Access\Response;

class SoftwarecompanyPolicy
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
    public function view(User $user, softwarecompany $softwarecompany): bool
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
    public function update(User $user, softwarecompany $softwarecompany): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, softwarecompany $softwarecompany): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, softwarecompany $softwarecompany): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, softwarecompany $softwarecompany): bool
    {
        //
    }
}
