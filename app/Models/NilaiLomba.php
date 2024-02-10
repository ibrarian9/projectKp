<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NilaiLomba extends Model
{
    use HasFactory;

    protected $table = 'nilai_lomba';
    protected $fillable = ['poin_nilai_lomba', 'id_kategori_penilaian','id_tim', 'id_pengaturan_juri'];
    protected $primaryKey = 'id_nilai';
    public $timestamps = false;


    public function nilaiLombaKategoriPenilaian(): belongsTo
    {
        return $this->belongsTo(KategoriPenilaian::class);
    }
    public function nilaiLombaTim(): belongsTo
    {
        return $this->belongsTo(Tim::class);
    }
    public function nilaiLombaJuri(): belongsTo
    {
        return $this->belongsTo(Juri::class);
    }
}
