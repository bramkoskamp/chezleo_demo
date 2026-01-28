<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'number_of_guests',
        'reservation_date',
        'reservation_time',
        'dinner_table_id',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
