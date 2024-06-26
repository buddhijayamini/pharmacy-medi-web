<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionImage extends Model
{
    use HasFactory;

    protected $table = 'prescription_images';

    protected $guarded = [];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
