<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable
{
    public $timestamps = false;
    protected $fillable = ['nama','email','telepon','password','role'];
    protected $hidden = ['password'];
    public function isAdmin(): bool { return $this->role === 'admin'; }
    public function reviews(): HasMany { return $this->hasMany(Review::class); }
    public function favorites(): HasMany { return $this->hasMany(Favorit::class); }
    public function mealHacks(): HasMany { return $this->hasMany(MealHack::class); }
}
