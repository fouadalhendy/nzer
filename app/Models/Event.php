<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'event_cost',
        'location',
        'event_img'
    ];
    public function client()
    {
        return $this->belongsTo('Client');
    }
    public function user()
    {
        return $this->belongsTo('User');
    }
}
