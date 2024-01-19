<?php

namespace App\Models;

use App\Http\Controllers\Universitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    
    protected $fillable = ['nama_peserta', 'nama_universitas'];

    protected $primaryKey = 'id_peserta';

    public function pesertaKeUniversitas()
    {
        return $this->belongsTo(Universitas::class);
    }

    public function univ() {
        return $this->join('universitas', 'peserta.id_universitas', "=", 'universitas.id_universitas')->select('peserta.*', 'universitas.nama_universitas');
    }

}
