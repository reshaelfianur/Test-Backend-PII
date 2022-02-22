<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Support\Facades\DB;

class Work_meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'work_meetings';
    protected $primaryKey   = 'wm_id';
    protected $fillable     = [
        'room_id',
        'wm_name',
        'wm_description',
        'wm_datetime_in',
        'wm_datetime_out',
        'wm_number_of_participants',
        'wm_agreement_status',
        'wm_agreement_note',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function facilities()
    {
        return $this->belongsToMany(Facility::class, 'work_meeting_facility');
    }

    public function minutesOfMeeting()
    {
        return $this->hasMany(Minutes_of_meeting::class, 'wm_id');
    }

    public function workMeetingParticipant()
    {
        return $this->hasMany(Work_meeting_participant::class, 'wm_id');
    }

    public static function fetch($args = [])
    {
        $i = new static;

        return self::select(
            $i->table . '.*',
            'c.room_name',
            DB::raw("CONCAT(d.employee_first_name, ' ', IFNULL(d.employee_last_name, '')) AS employee_full_name")
        )
            ->join('users AS b', $i->table . '.created_by', '=', 'b.user_id')
            ->leftJoin('employees AS d', 'b.employee_id', '=', 'd.employee_id')
            ->join('rooms AS c', $i->table . '.room_id', '=', 'c.room_id')
            ->where($args)
            ->get();
    }
}
