<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Juri extends Model
{
    use HasFactory;

    protected $table = 'juri';
    protected $primaryKey = 'id_juri';

    public function pengaturanJuri(): BelongsTo
    {
        return $this->belongsTo(PengaturanJuri::class, 'id_juri');
    }
}
