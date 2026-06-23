<?php

namespace App\Services;

class KpiCalculationService
{
    public function getGradeProjectCoefficient(string $role, string $grade): float
    {
        return match ($grade) {
            'A' => 2.0,
            'B' => 1.0,
            'C' => 0.5,
            default => 0,
        };
    }

    public function calculateTotalMandaysPenugasan(float $mandays, float $koefisienOntime, float $koefisienGrade): float
    {
        $jumlah = $koefisienOntime + $koefisienGrade;
        return ($mandays * $jumlah) / 2;
    }

    public function calculatePoint(float $koefisien, float $mandays): float
    {
        return $koefisien * $mandays;
    }
}
