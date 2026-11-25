<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Favorit extends Model
{
    protected $table = 'favorit';
    public $timestamps = false;
    protected $fillable = ['user_id','tempat_id'];
    public function tempat() { return $this->belongsTo(Tempat::class); }
    public function user() { return $this->belongsTo(User::class); }
}
