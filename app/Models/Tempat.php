<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tempat extends Model
{
    protected $table = 'tempat';
    public $timestamps = false;
    protected $fillable = ['nama','kategori','jenis','jarak_km','harga_min','harga_max','foto','rating_dasar','ulasan_dasar','rekomendasi','dibuat_oleh'];
    public function reviews() { return $this->hasMany(Review::class); }
    public function favorites() { return $this->hasMany(Favorit::class); }
    public function creator() { return $this->belongsTo(User::class, 'dibuat_oleh'); }
    public function getRatingAttribute(): float {
        $count = $this->reviews_count ?? $this->reviews()->count();
        $sum = $this->reviews_sum_rating ?? $this->reviews()->sum('rating');
        $total = $this->ulasan_dasar + $count;
        return $total ? ($this->rating_dasar * $this->ulasan_dasar + $sum) / $total : 0;
    }
    public function getUlasanAttribute(): int { return $this->ulasan_dasar + ($this->reviews_count ?? $this->reviews()->count()); }
    public function getPhotoUrlAttribute(): string { return str_starts_with((string)$this->foto, 'https://') ? $this->foto : ($this->foto ? asset($this->foto) : ''); }
    public function scopeWithRatings($query) { return $query->withCount('reviews')->withSum('reviews','rating'); }
}
