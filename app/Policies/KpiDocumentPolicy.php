<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KpiDocument;
use Illuminate\Auth\Access\HandlesAuthorization;

class KpiDocumentPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KpiDocument');
    }

    public function view(AuthUser $authUser, KpiDocument $kpiDocument): bool
    {
        return $authUser->can('View:KpiDocument');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KpiDocument');
    }

    public function update(AuthUser $authUser, KpiDocument $kpiDocument): bool
    {
        return $authUser->can('Update:KpiDocument');
    }

    public function delete(AuthUser $authUser, KpiDocument $kpiDocument): bool
    {
        return $authUser->can('Delete:KpiDocument');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KpiDocument');
    }

    public function restore(AuthUser $authUser, KpiDocument $kpiDocument): bool
    {
        return $authUser->can('Restore:KpiDocument');
    }

    public function forceDelete(AuthUser $authUser, KpiDocument $kpiDocument): bool
    {
        return $authUser->can('ForceDelete:KpiDocument');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KpiDocument');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KpiDocument');
    }

    public function replicate(AuthUser $authUser, KpiDocument $kpiDocument): bool
    {
        return $authUser->can('Replicate:KpiDocument');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KpiDocument');
    }

}