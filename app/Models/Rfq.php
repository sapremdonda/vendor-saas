<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'title', 'description', 'items_required', 'deadline', 'status'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function vendors()
    {
        return $this->belongsToMany(Vendor::class);
    }
}