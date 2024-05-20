<?php

namespace App\Policies;

use App\Models\PersonalInformation;
use App\Models\User;

class PersonalInformationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user, string $address_prefix = null): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PersonalInformation $personalInformation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PersonalInformation $personalInformation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PersonalInformation $personalInformation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PersonalInformation $personalInformation): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PersonalInformation $personalInformation): bool
    {
        return false;
    }
}
