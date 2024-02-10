<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriPenilaian extends Model
{
    use HasFactory;

    protected $table = 'kategori_penilaian';
    protected $fillable = 'nama_kategori';
    protected $primaryKey = 'id_kategori';

    public function kategoriPenilaianLomba()
    {
        return $this->belongsTo(Lomba::class);
    }
    public function kategoriPenilaianNilaiLomba()
    {
        return $this->hasMany(nilaiLomba::class);
    }


}
