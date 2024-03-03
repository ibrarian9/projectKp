<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengaturanJuri extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_juri';
    protected $fillable = ['tanggal_pemeriksaan'];
    protected $primaryKey = 'id_pengaturan_juri';

    public $timestamps = false;
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function nomorLomba(): BelongsTo
    {
        return $this->belongsTo(NomorPerlombaan::class, 'id_nomor_perlombaan');
    }

    public function nilaiLomba(): BelongsTo
    {
        return $this->belongsTo(NilaiLomba::class, 'id_pengaturan_juri');
    }
}
