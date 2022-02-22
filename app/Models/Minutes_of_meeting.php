<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Minutes_of_meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'minutes_of_meeting';
    protected $primaryKey   = 'mom_id';
    protected $fillable     = [
        'wm_id',
        'wmp_id',
        'mom_result_of_meeting',
        'mom_note_status',
    ];

    public function workMeeting()
    {
        return $this->belongsTo(Work_meeting::class, 'wm_id');
    }

    public function workMeetingParticipant()
    {
        return $this->belongsTo(Work_meeting_participant::class, 'wmp_id');
    }

    public static function fetch($args = [])
    {
        $i = new static;

        return self::select(
            $i->table . '.*',
            'b.wm_name',
            DB::raw("CONCAT(d.employee_first_name, ' ', IFNULL(d.employee_last_name, '')) AS employee_full_name")
        )
            ->join('work_meetings AS b', $i->table . '.wm_id', '=', 'b.wm_id')
            ->join('work_meeting_participants AS c', $i->table . '.wmp_id', '=', 'c.wmp_id')
            ->join('employees AS d', 'c.employee_id', '=', 'd.employee_id')
            ->where($args)
            ->get();
    }
}
