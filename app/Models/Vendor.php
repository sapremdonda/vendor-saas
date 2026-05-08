<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'company'];

    public function rfqs()
    {
        return $this->belongsToMany(Rfq::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }
}