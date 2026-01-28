<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DinnerTable extends Model
{
    use HasFactory;

    protected $table = 'dinner_tables';  // De tabelnaam
    protected $fillable = ['name', 'seats']; // Zorg ervoor dat je de juiste kolommen in de fillable zet

    public function reservations()
    {   
        return $this->hasMany(Reservation::class);
    }


}






