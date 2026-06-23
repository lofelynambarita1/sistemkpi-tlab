<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KpiAnnualTarget;
use Illuminate\Auth\Access\HandlesAuthorization;

class KpiAnnualTargetPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KpiAnnualTarget');
    }

    public function view(AuthUser $authUser, KpiAnnualTarget $kpiAnnualTarget): bool
    {
        return $authUser->can('View:KpiAnnualTarget');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KpiAnnualTarget');
    }

    public function update(AuthUser $authUser, KpiAnnualTarget $kpiAnnualTarget): bool
    {
        return $authUser->can('Update:KpiAnnualTarget');
    }

    public function delete(AuthUser $authUser, KpiAnnualTarget $kpiAnnualTarget): bool
    {
        return $authUser->can('Delete:KpiAnnualTarget');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KpiAnnualTarget');
    }

    public function restore(AuthUser $authUser, KpiAnnualTarget $kpiAnnualTarget): bool
    {
        return $authUser->can('Restore:KpiAnnualTarget');
    }

    public function forceDelete(AuthUser $authUser, KpiAnnualTarget $kpiAnnualTarget): bool
    {
        return $authUser->can('ForceDelete:KpiAnnualTarget');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KpiAnnualTarget');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KpiAnnualTarget');
    }

    public function replicate(AuthUser $authUser, KpiAnnualTarget $kpiAnnualTarget): bool
    {
        return $authUser->can('Replicate:KpiAnnualTarget');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KpiAnnualTarget');
    }

}