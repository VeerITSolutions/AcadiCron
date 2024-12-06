<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sections extends Model
{
    use HasFactory;

    protected $fillable = ['section'];

    protected $table = 'sections';

    public function classSections()
    {
        return $this->hasMany(ClassSections::class, 'section_id');
    }
}
