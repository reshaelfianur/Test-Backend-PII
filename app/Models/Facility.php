<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'facilities';
    protected $primaryKey   = 'facility_id';
    protected $fillable     = [
        'facility_name',
        'facility_description',
    ];

    public function workMeetings()
    {
        return $this->belongsToMany(Work_meeting::class, 'work_meeting_facility');
    }
}
