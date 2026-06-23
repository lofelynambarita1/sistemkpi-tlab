<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KpiApproval;
use Illuminate\Auth\Access\HandlesAuthorization;

class KpiApprovalPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KpiApproval');
    }

    public function view(AuthUser $authUser, KpiApproval $kpiApproval): bool
    {
        return $authUser->can('View:KpiApproval');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KpiApproval');
    }

    public function update(AuthUser $authUser, KpiApproval $kpiApproval): bool
    {
        return $authUser->can('Update:KpiApproval');
    }

    public function delete(AuthUser $authUser, KpiApproval $kpiApproval): bool
    {
        return $authUser->can('Delete:KpiApproval');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KpiApproval');
    }

    public function restore(AuthUser $authUser, KpiApproval $kpiApproval): bool
    {
        return $authUser->can('Restore:KpiApproval');
    }

    public function forceDelete(AuthUser $authUser, KpiApproval $kpiApproval): bool
    {
        return $authUser->can('ForceDelete:KpiApproval');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KpiApproval');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KpiApproval');
    }

    public function replicate(AuthUser $authUser, KpiApproval $kpiApproval): bool
    {
        return $authUser->can('Replicate:KpiApproval');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KpiApproval');
    }

}