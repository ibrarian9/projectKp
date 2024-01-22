<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lomba extends Model
{
    use HasFactory;

    protected $table = 'lomba';

    protected $fillable = ['id_tim_lomba', 'nama_lomba', 'anggota_tim_minimal', 'anggota_tim_maksimal'];

    protected $primaryKey = 'id_lomba';

    public function timLomba(): HasMany
    {
        return $this->hasMany(TimLomba::class);
    }
}
