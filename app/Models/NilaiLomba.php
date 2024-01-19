<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiLomba extends Model
{
    use HasFactory;

    protected $table = 'nilai_lomba';
    
    protected $fillable = 'poin_lomba';

    protected $primaryKey = 'id_nilai';


    public function nilaiLombaKategoriPenilaian()
    {
        return $this->belongsTo(KategoriPenilaian::class);
    }
    public function nilaiLombaTim()
    {
        return $this->belongsTo(Tim::class);
    }
    public function nilaiLombaJuri()
    {
        return $this->belongsTo(Juri::class);
    }
}
