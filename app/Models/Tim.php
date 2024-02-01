<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tim extends Model
{
    use HasFactory;

    protected $table = 'tim';
    protected $primaryKey = 'id_tim';

    public function peserta(): BelongsTo
    {
       return $this->belongsTo(Peserta::class, 'id_peserta');
    }

    public function tim(): BelongsTo
    {
       return $this->belongsTo(Tim::class, 'id_tim');
    }

    public function nomorLomba(): HasMany
    {
        return $this->hasMany(NomorPerlombaan::class);
    }
}
