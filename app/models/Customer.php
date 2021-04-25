<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';
    protected $fillable = ['company', 'first_name', 'last_name', 'email_address', 'job_title', 'business_phone', 'address', 'city', 'zip_postal_code', 'country_region'];
    public $timestamps = false;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getTotalPrice()
    {
        $order_ids = $this->orders()->pluck('id')->toArray();
        $total = OrderDetail::query()
            ->whereIn('order_id', $order_ids)
            ->selectRaw('SUM(quantity * unit_price) as sum')
            ->first();

        return $total ? (float)$total->sum : 0;
    }
}
