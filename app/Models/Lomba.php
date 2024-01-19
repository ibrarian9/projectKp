<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    use HasFactory;

    protected $table = ['lomba', 'tim_lomba'];
    
    protected $fillable = ['id_tim_lomba', 'nama_lomba', 'anggota_tim_minimal', 'anggota_tim_maksimal'];

    protected $primaryKey = 'id_lomba';


    public function lombaKeKategoriPenilaian()
    {
        return $this->hasMany('App\Models\KategoriPenilaian');
    }


    // // Metode validasi data
    // public function rules()
    // {
    //     return [
    //         'kolom_1' => 'required',
    //         'kolom_2' => 'numeric',
    //         // ...
    //     ];
    // }

}
