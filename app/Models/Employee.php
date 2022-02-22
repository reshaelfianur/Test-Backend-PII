<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table      = 'employees';
    protected $primaryKey = 'employee_id';
    protected $fillable   = [
        // 'origin_id',
        // 'religion_id',
        // 'ms_id',
        // 'pr_id',
        'employee_code',
        'employee_first_name',
        'employee_last_name',
        // 'employee_id_card',
        // 'employee_nation',
        // 'employee_gender',
        // 'employee_passport_no',
        'employee_phone_no',
        // 'employee_birth_date',
        // 'employee_birth_place',
        // 'employee_married_since',
        // 'employee_email_private',
        // 'employee_email_company',
        // 'employee_is_retire',
        // 'employee_retire_date',
        // 'employee_join_date',
        // 'employee_probation_enddate',
        // 'employee_permanent_date',
        // 'employee_resign_date',
        // 'employee_picture',
        // 'created_by',
        // 'updated_by',
        // 'deleted_by'
    ];

    public function workMeetingParticipant()
    {
        return $this->hasMany(Work_meeting_participant::class, 'employee_id');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'employee_id');
    }

    public static function fetch($args = [])
    {
        $i = new static;

        return self::select(
            $i->table . '.*',
            DB::raw("CONCAT($i->table.employee_first_name, ' ', IFNULL($i->table.employee_last_name, '')) AS employee_full_name")
        )
            ->where($args)
            ->get();
    }

    public static function searchListEmpName($words)
    {
        return self::where(DB::raw("CONCAT_WS('',employee_first_name, ' ', employee_last_name)"), 'LIKE', '%' . $words . '%')
            ->get();
    }
}
