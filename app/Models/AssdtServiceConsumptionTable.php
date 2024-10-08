<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssdtServiceConsumptionTable extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'scode',
        'servicename',
        'servicetype',
        'transmat',
        'chargemat',
        'req_dt',
        'status'
    ];
}
