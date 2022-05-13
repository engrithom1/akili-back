<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details';
    protected $primaryKey = 'id';
    protected $fillable = ['now_price','quantity','order_id','product_id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
