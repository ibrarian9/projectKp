<?php

namespace App\Models;

use App\Http\Controllers\Universitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    use HasFactory;

    protected $table = ['tim', 'tim_lomba'];
    
    protected $fillable = ['nama_tim', 'nama_universitas'];

    protected $primaryKey = 'id_tim';

    public function timKeUniversitas()
    {
        return $this->belongsTo(Universitas::class);
    }
    public function timKePeserta()
    {
        return $this->belongsTo(Peserta::class);
    }
    public function timUniv() {
        return $this->join('universitas', 'peserta', 'tim.id_universitas', "=", 'universitas.id_universitas', '=', 'peserta.id_universitas')->select('peserta.*', 'universitas.nama_universitas');
    }

}
