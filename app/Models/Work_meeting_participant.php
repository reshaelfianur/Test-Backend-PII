<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Work_meeting_participant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'work_meeting_participants';
    protected $primaryKey   = 'wmp_id';
    protected $fillable     = [
        'wm_id',
        'employee_id',
        'wmp_absence_status',
        'wmp_datetime_absence',
        'wmp_absence_note',
        'wmp_is_minutes',
    ];

    public function workMeeting()
    {
        return $this->belongsTo(Work_meeting::class, 'wm_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function minutesOfMeeting()
    {
        return $this->hasMany(Minutes_of_meeting::class, 'wmp_id');
    }

    public static function fetch($args = [])
    {
        $i = new static;

        return self::select(
            $i->table . '.*',
            'c.wm_name',
            DB::raw("CONCAT(b.employee_first_name, ' ', IFNULL(b.employee_last_name, '')) AS employee_full_name")
        )
            ->join('employees AS b', $i->table . '.employee_id', '=', 'b.employee_id')
            ->join('work_meetings AS c', $i->table . '.wm_id', '=', 'c.wm_id')
            ->where($args)
            ->get();
    }
}
