<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = 'events';

    protected $fillable = [
        'title',
        'calendar_id',
        'content',
        'is_allday',
        'is_private',
        'state',
        'start',
        'end',
        'event_id',
        'attendees',
        'category',
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'calendar_id', 'id')->select('id', 'name', 'color');
    }
}
