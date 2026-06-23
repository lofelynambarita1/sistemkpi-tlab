<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\KpiDocumentHistory;
use Illuminate\Auth\Access\HandlesAuthorization;

class KpiDocumentHistoryPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:KpiDocumentHistory');
    }

    public function view(AuthUser $authUser, KpiDocumentHistory $kpiDocumentHistory): bool
    {
        return $authUser->can('View:KpiDocumentHistory');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:KpiDocumentHistory');
    }

    public function update(AuthUser $authUser, KpiDocumentHistory $kpiDocumentHistory): bool
    {
        return $authUser->can('Update:KpiDocumentHistory');
    }

    public function delete(AuthUser $authUser, KpiDocumentHistory $kpiDocumentHistory): bool
    {
        return $authUser->can('Delete:KpiDocumentHistory');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:KpiDocumentHistory');
    }

    public function restore(AuthUser $authUser, KpiDocumentHistory $kpiDocumentHistory): bool
    {
        return $authUser->can('Restore:KpiDocumentHistory');
    }

    public function forceDelete(AuthUser $authUser, KpiDocumentHistory $kpiDocumentHistory): bool
    {
        return $authUser->can('ForceDelete:KpiDocumentHistory');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:KpiDocumentHistory');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:KpiDocumentHistory');
    }

    public function replicate(AuthUser $authUser, KpiDocumentHistory $kpiDocumentHistory): bool
    {
        return $authUser->can('Replicate:KpiDocumentHistory');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:KpiDocumentHistory');
    }

}