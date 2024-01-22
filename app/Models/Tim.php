<?php

namespace App\Models;

use App\Http\Controllers\Universitas;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tim extends Model
{
    use HasFactory;

    protected $table = 'tim';

    protected $fillable = ['id_tim', 'id_peserta', 'id_universitas'];

    protected $primaryKey = 'id_tim';

    public function universitas(): BelongsTo
    {
        return $this->belongsTo(Universitas::class);
    }
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(Peserta::class);
    }

    public function timLomba() {
        return $this->hasMany(TimLomba::class);
    }
}
