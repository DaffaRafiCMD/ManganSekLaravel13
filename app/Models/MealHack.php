<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MealHack extends Model
{
    protected $table = 'meal_hack';
    public $timestamps = false;
    protected $fillable = ['user_id','judul','deskripsi','hemat','ikon'];
    public function user() { return $this->belongsTo(User::class); }
}
