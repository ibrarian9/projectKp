<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lomba extends Model
{
    use HasFactory;

    protected $table = 'lomba';
    protected $primaryKey = 'id_lomba';

    public function nomorLomba(): HasMany
    {
        return $this->hasMany(NomorPerlombaan::class, 'id_lomba');
    }
}
