<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goat extends Model
{
    use HasFactory;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function mother(){
        return $this->belongsTo(Goat::class,'mother_id');
    }
    public function father(){
        return $this->belongsTo(Goat::class,'father_id');
    }

    public function reports(){
        return $this->hasMany(Report::class,'goat_id');
    }
    public function transactions(){
        return $this->hasMany(Transaction::class,'goat_id');
    }
    public function children(){
        return $this->hasMany(Goat::class,'mother_id')->orderBy('date_of_birth');
    }
}
