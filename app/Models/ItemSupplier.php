<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemSupplier extends Model
{
    use HasFactory;

    protected $table = 'item_supplier';

    public $timestamps = false;

    protected $fillable = [
        'item_supplier',
        'phone',
        'email',
        'address',
        'contact_person_name',
        'contact_person_phone',
        'contact_person_email',
        'description',
    ];
}
