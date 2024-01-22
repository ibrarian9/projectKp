<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    use HasFactory;

    protected $table = 'universitas';

    protected $fillable = ['nama_universitas'];

    protected $primaryKey = 'id_universitas';


    public function UniversitasPeserta()
    {
        return $this->hasMany(Peserta::class);
    }
}
