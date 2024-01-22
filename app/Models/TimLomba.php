<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimLomba extends Model
{
    use HasFactory;

    protected $table = 'tim_lomba';

    protected $fillable = ['id_tim', 'id_lomba'];

    protected $primaryKey = 'id_tim_lomba';

    public function lomba(): BelongsTo
    {
        return $this->belongsTo(Lomba::class, 'id_lomba');
    }

    public function tim(): BelongsTo
    {
        return $this->belongsTo(Tim::class, 'id_tim');
    }

}
