<?php

namespace App\Models;

use App\Http\Controllers\Universitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';


    protected $fillable = ['nama_peserta', 'nama_universitas', 'id_universitas'];

    protected $primaryKey = 'id_peserta';

    public function universitas(): BelongsTo
    {
        return $this->belongsTo(Universitas::class);
    }
}
