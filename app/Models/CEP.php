<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CEP extends Model
{
    
    protected $table = 'ceps_calculation';
	protected $fillable = ['origin', 'destination', 'distance'];
	protected $hidden = ['updated_at', 'created_at'];

}
