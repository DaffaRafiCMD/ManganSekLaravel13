<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Promo extends Model
{
    protected $table = 'promo';
    public $timestamps = false;
    protected $fillable = ['judul','warna','nama_tempat','kategori','deskripsi','syarat','berlaku_sampai'];
    
}
