<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'company_id'];
}
