<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['item_name', 'item_description', 'item_status', 'item_type', 'item_pic', 'latitude', 'longitude', 'reported_date', 'reported_time', 'user_id'];
}
