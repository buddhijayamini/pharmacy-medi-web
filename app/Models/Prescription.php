<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $table = 'prescriptions';

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(Prescription::class, 'id', 'user_id');
    }

    public function images()
    {
        return $this->hasMany(PrescriptionImage::class);
    }
}
