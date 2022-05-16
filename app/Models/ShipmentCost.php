<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentCost extends Model
{
    use HasFactory;
    protected $guarded = ['id']; 
    protected $appends = ['number_of_sales'];

    public function getNumberOfSalesAttribute()
    {
        return Sales::where('shipping_cost',$this->cost)->count();
    }
}
