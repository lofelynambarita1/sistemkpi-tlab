<?php

// app/Models/Kpi.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kpi extends Model
{
    protected $primaryKey = 'kpi_id';
    protected $fillable = ['employee_id', 'manager_id', 'periode_penilaian', 'tahun', 'status', 'total_nilai'];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'user_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'user_id');
    }

    
    public function jobdesc()
    {
        return $this->hasOne(KpiJobdesc::class, 'kpi_id', 'kpi_id');
    }

    public function continuesImprovements()
    {
        return $this->hasMany(KpiContinuesImprovement::class, 'kpi_id', 'kpi_id');
    }

    public function selfDevelopments()
    {
        return $this->hasMany(KpiSelfDevelopment::class, 'kpi_id', 'kpi_id');
    }

    public function hrActivities()
    {
        return $this->hasMany(KpiHrActivity::class, 'kpi_id', 'kpi_id');
    }

    
    public function behaviors()
    {
        return $this->hasMany(KpiBehavior::class, 'kpi_id', 'kpi_id');
    }

    public function reviews()
    {
        return $this->hasMany(KpiReview::class, 'kpi_id', 'kpi_id');
    }
}