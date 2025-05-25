<?php

namespace App\Policies;

use App\Models\Job;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class JobPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Job $job): bool
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
    public function update(User $user, Job $job): bool
    {
        return $this->isOwner($user, $job) ;
//                return $user->id === $job->company->user_id ? Response::allow() : Response::deny('You are not authorized to perform this action.');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Job $job): bool
    {
        return $this->isOwner($user, $job);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Job $job): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Job $job): bool
    {
        return false;
    }

    public function toggle(User $user, Job $job)
    {
        return $this->isOwner($user, $job);
    }

    public function isOwner(User $user, Job $job){
        return $user->id === $job->company->user_id || $user->role?->name === 'admin';
//        return $user->id === $job->company->user_id ? Response::allow() : Response::deny('You are not authorized to perform this action.');

    }
}
