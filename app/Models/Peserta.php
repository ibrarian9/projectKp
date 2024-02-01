<?php

namespace App\Models;

use App\Models\Universitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';
    protected $fillable = ['nama_peserta', 'id_universitas'];
    protected $primaryKey = 'id_peserta';

    public function tim(): HasMany
    {
        return $this->HasMany(Tim::class, 'peserta_id');
    }
    public function universitas(): BelongsTo
    {
        return $this->belongsTo(Universitas::class, 'id_universitas');
    }
}
