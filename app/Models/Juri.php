<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Juri extends Model
{
    use HasFactory;
    
    protected $table = 'juri';
    
    protected $fillable = 'nama_juri';

    protected $primaryKey = 'id_juri';

    public function juriNilaiLomba()
    {
        return $this->hasMany(NilaiLomba::class);

    }
}