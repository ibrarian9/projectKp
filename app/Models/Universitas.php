<?php

namespace App\Models;

use App\Models\Peserta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Universitas extends Model
{
    use HasFactory;

    protected $table = 'universitas';
    protected $primaryKey = 'id_universitas';

    public function peserta(): HasMany
    {
        return $this->hasMany(Peserta::class,'id_universitas');
    }
}
