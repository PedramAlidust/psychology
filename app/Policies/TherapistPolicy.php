<?php

namespace App\Policies;

use App\Models\Therapist;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TherapistPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    /*Policy for Index */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    /*Policy for show */
    public function view(?User $user, Therapist $therapist): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    /* Policy for create */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    /* Policy for update */
    public function update(User $user, Therapist $therapist): bool
    {
        return $user->id === $therapist->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    /* Policy for destroy */
    public function delete(User $user, Therapist $therapist): bool
    {
        return $user->role == 'admin';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Therapist $therapist)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Therapist $therapist)
    {
        //
    }
}
