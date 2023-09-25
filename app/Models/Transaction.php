<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function report(){
        return $this->belongsTo(Report::class,'report_id');
    }
    public function goat(){
        return $this->belongsTo(Goat::class,'goat_id');
    }
    public function customer(){
        return $this->belongsTo(Customer::class,'customer_id');
    }
}
