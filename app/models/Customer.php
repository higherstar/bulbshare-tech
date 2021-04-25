<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';
    protected $fillable = ['company', 'first_name', 'last_name', 'email_address', 'job_title', 'business_phone', 'address', 'city', 'zip_postal_code', 'country_region'];
    public $timestamps = false;
}
