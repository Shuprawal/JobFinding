<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApplicationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role?->name === 'Admin';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Application $application): bool
    {

        return $this->isOwner($user, $application);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Application $application): bool
    {

        return $user->role?->name === 'User';

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Application $application): bool
    {

        return $application->user_id === $user->id;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Application $application): bool
    {
        return $this->isOwner($user, $application);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Application $application): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Application $application): bool
    {
        return false;
    }

    public function isOwner(User $user, Application $application)
    {
        return $application->job->company->user->id === $user->id || $application->user_id === $user->id || $user->role?->name === 'admin';
    }
}
