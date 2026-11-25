<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Review extends Model
{
    protected $table = 'review';
    public $timestamps = false;
    protected $fillable = ['tempat_id','user_id','rating','komentar'];
    public function tempat() { return $this->belongsTo(Tempat::class); }
    public function user() { return $this->belongsTo(User::class); }
}
