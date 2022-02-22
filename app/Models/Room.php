<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $table        = 'rooms';
    protected $primaryKey   = 'room_id';
    protected $fillable     = [
        'room_name',
        'room_capacity',
        'room_description',
    ];

    public function workMeeting()
    {
        return $this->hasMany(Work_meeting::class, 'room_id');
    }
}
