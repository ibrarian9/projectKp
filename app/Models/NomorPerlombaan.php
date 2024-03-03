<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NomorPerlombaan extends Model
{
    use HasFactory;

    protected $table = 'nomor_perlombaan';
    protected $primaryKey = 'id_nomor_perlombaan';

    public function lomba(): BelongsTo
    {
        return $this->belongsTo(Lomba::class, 'id_lomba');
    }

    public function tim(): HasMany
    {
        return $this->hasMany(Tim::class, 'id_nomor_perlombaan');
    }

    public function pengaturanJuri(): BelongsTo
    {
        return $this->belongsTo(PengaturanJuri::class, 'id_nomor_perlombaan');
    }
}
