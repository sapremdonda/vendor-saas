<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;

    protected $fillable = ['rfq_id', 'vendor_id', 'price', 'notes', 'attachment', 'status'];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}