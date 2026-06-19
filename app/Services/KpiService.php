<?php

namespace App\Services;

use App\Models\KpiApproval;
use App\Models\KpiForm;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KpiService
{
    public function submit(KpiForm $form, User $submitter): void
    {
        DB::transaction(function () use ($form, $submitter) {
            $form->status       = KpiForm::STATUS_SUBMITTED;
            $form->submitted_at = now();

            if (in_array($submitter->role, ['associate', 'intermediate', 'senior'])) {
                $form->status = KpiForm::STATUS_WAITING_LEAD;
                $approver = User::where('role', 'lead')->first();
            } elseif ($submitter->role === 'lead') {
                $form->status = KpiForm::STATUS_WAITING_LHR;
                $approver = User::where('role', 'lead_hr')->first();
            } elseif (in_array($submitter->role, ['principle', 'lead_hr'])) {
                $form->status = KpiForm::STATUS_WAITING_MGR;
                $approver = User::where('role', 'manager')->first();
            } else {
                $approver = null;
            }

            $form->current_approver_id = $approver?->id;
            $form->save();

            $this->logAction($form, $submitter, 'submitted');
        });
    }

    public function approveByLead(KpiForm $form, User $lead, ?string $komentar = null): void
    {
        DB::transaction(function () use ($form, $lead, $komentar) {
            $lhr = User::where('role', 'lead_hr')->first();
            $form->status              = KpiForm::STATUS_WAITING_LHR;
            $form->current_approver_id = $lhr?->id;
            $form->save();
            $this->logAction($form, $lead, 'approved_lead', $komentar);
        });
    }

    public function rejectByLead(KpiForm $form, User $lead, ?string $komentar = null): void
    {
        DB::transaction(function () use ($form, $lead, $komentar) {
            $form->status              = KpiForm::STATUS_NEED_REVISION;
            $form->current_approver_id = null;
            $form->save();
            $this->logAction($form, $lead, 'rejected_lead', $komentar);
        });
    }

    public function approveByLeadHR(KpiForm $form, User $leadHR, ?string $komentar = null): void
    {
        DB::transaction(function () use ($form, $leadHR, $komentar) {
            $manager = User::where('role', 'manager')->first();
            $form->status              = KpiForm::STATUS_WAITING_MGR;
            $form->current_approver_id = $manager?->id;
            $form->save();
            $this->logAction($form, $leadHR, 'approved_lead_hr', $komentar);
        });
    }

    public function rejectByLeadHR(KpiForm $form, User $leadHR, ?string $komentar = null): void
    {
        DB::transaction(function () use ($form, $leadHR, $komentar) {
            $form->status              = KpiForm::STATUS_NEED_REVISION;
            $form->current_approver_id = null;
            $form->save();
            $this->logAction($form, $leadHR, 'rejected_lead_hr', $komentar);
        });
    }

    public function approveByManager(KpiForm $form, User $manager, ?string $komentar = null): void
    {
        DB::transaction(function () use ($form, $manager, $komentar) {
            $form->status              = KpiForm::STATUS_APPROVED;
            $form->current_approver_id = null;
            $form->save();
            $this->logAction($form, $manager, 'approved_manager', $komentar);
        });
    }

    public function rejectByManager(KpiForm $form, User $manager, ?string $komentar = null): void
    {
        DB::transaction(function () use ($form, $manager, $komentar) {
            $form->status              = KpiForm::STATUS_NEED_REVISION;
            $form->current_approver_id = null;
            $form->save();
            $this->logAction($form, $manager, 'rejected_manager', $komentar);
        });
    }

    public function bulkApprove(array $formIds, User $approver, ?string $komentar = null): void
    {
        $forms = KpiForm::whereIn('id', $formIds)->get();
        foreach ($forms as $form) {
            match ($approver->role) {
                'lead'    => $this->approveByLead($form, $approver, $komentar),
                'lead_hr' => $this->approveByLeadHR($form, $approver, $komentar),
                'manager' => $this->approveByManager($form, $approver, $komentar),
                default   => null,
            };
        }
    }

    public function bulkReject(array $formIds, User $approver, ?string $komentar = null): void
    {
        $forms = KpiForm::whereIn('id', $formIds)->get();
        foreach ($forms as $form) {
            match ($approver->role) {
                'lead'    => $this->rejectByLead($form, $approver, $komentar),
                'lead_hr' => $this->rejectByLeadHR($form, $approver, $komentar),
                'manager' => $this->rejectByManager($form, $approver, $komentar),
                default   => null,
            };
        }
    }

    private function logAction(KpiForm $form, User $actor, string $action, ?string $komentar = null): void
    {
        KpiApproval::create([
            'kpi_form_id' => $form->id,
            'actor_id'    => $actor->id,
            'action'      => $action,
            'komentar'    => $komentar,
            'acted_at'    => now(),
        ]);
    }
}
