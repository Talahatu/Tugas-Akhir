<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    use HasFactory;

    protected $table = "courier";

    public function deliveries()
    {
        return $this->hasMany(Delivery::class, "courier_id", "id");
    }
}
