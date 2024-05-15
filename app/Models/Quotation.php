<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $table = 'quotations';

    protected $guarded = [];

    public function items()
    {
        return $this->hasMany(QuotationItem::class, 'quotation_id', 'id');
    }
}
