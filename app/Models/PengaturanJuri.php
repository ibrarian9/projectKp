<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PengaturanJuri extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_juri';
    protected $primaryKey = 'id_pengaturan_juri';

    public function juri(): HasMany
    {
        return $this->hasMany(Juri::class, 'id_juri');
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
