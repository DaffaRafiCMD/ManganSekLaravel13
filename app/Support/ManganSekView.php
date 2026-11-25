<?php
namespace App\Support;
final class ManganSekView {
public static function rupiah($n): string
{
    return number_format((float) $n, 0, ',', '.');
}

public static function harga_range(array|\ArrayAccess $t): string
{
    return 'Rp ' . self::rupiah($t['harga_min']) . ' – ' . self::rupiah($t['harga_max']);
}

public static function tanggal_id(string $date): string
{
    $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $ts = strtotime($date);
    return date('j', $ts) . ' ' . $bulan[(int) date('n', $ts) - 1] . ' ' . date('Y', $ts);
}

public static function waktu_lalu(string $datetime): string
{
    $selisih = max(0, time() - strtotime($datetime));
    if ($selisih < 60)        return 'baru saja';
    if ($selisih < 3600)      return floor($selisih / 60) . ' menit lalu';
    if ($selisih < 86400)     return floor($selisih / 3600) . ' jam lalu';
    if ($selisih < 604800)    return floor($selisih / 86400) . ' hari lalu';
    if ($selisih < 2592000)   return floor($selisih / 604800) . ' minggu lalu';
    if ($selisih < 31536000)  return floor($selisih / 2592000) . ' bulan lalu';
    return floor($selisih / 31536000) . ' tahun lalu';
}

public static function stars_html(int $n): string
{
    $n = max(0, min(5, $n));
    return '<span class="stars" role="img" aria-label="Rating ' . $n . ' dari 5">'
        . str_repeat(self::ui_icon('star'), $n)
        . '<span class="off">' . str_repeat(self::ui_icon('star'), 5 - $n) . '</span></span>';
}


// Ikon garis sederhana (SVG), menggantikan seluruh emoji dalam antarmuka.
public static function ui_icon(string $name): string
{
    $icons = [
        'utensils' => '<path d="M4 3v7a3 3 0 0 0 6 0V3M7 3v18M15 3v7a3 3 0 0 0 6 0V3M18 13v8"/>',
        'user' => '<circle cx="12" cy="8" r="4"/><path d="M4 21v-2a8 8 0 0 1 16 0v2"/>',
        'users' => '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM22 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>',
        'shield' => '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/><path d="m9 12 2 2 4-4"/>',
        'search' => '<circle cx="11" cy="11" r="7"/><path d="m16 16 5 5"/>',
        'pin' => '<path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z"/><circle cx="12" cy="10" r="2.5"/>',
        'star' => '<path d="m12 2 3 6.5 7 .9-5.1 5 .9 7.1L12 18l-5.8 3.5.9-7.1-5.1-5 7-.9L12 2Z"/>',
        'heart' => '<path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8L12 21l8.8-8.6a5.5 5.5 0 0 0 0-7.8Z"/>',
        'edit' => '<path d="M12 20h9M4 17l-.5 4.5L8 21 20 9l-4-4L4 17ZM14 7l4 4"/>',
        'lock' => '<rect x="4" y="11" width="16" height="11" rx="2"/><path d="M8 11V7a4 4 0 1 1 8 0v4"/>',
        'plus' => '<path d="M12 5v14M5 12h14"/>',
        'grid' => '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>',
        'tag' => '<path d="M3 3h9l9 9-9 9-9-9V3Z"/><circle cx="8" cy="8" r="1.5"/>',
        'lightbulb' => '<path d="M9 18h6M10 22h4M8 15a7 7 0 1 1 8 0l-1 3H9l-1-3Z"/>',
        'calendar' => '<rect x="3" y="5" width="18" height="16" rx="2"/><path d="M7 3v4M17 3v4M3 10h18"/>',
        'list' => '<path d="M9 6h12M9 12h12M9 18h12M4 6h.01M4 12h.01M4 18h.01"/>',
        'image' => '<rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="m21 15-5-5L5 21"/>',
        'message' => '<path d="M21 11.5a8.5 8.5 0 0 1-8.5 8.5 9 9 0 0 1-4-.9L3 21l1.9-5.5a9 9 0 0 1-.9-4A8.5 8.5 0 0 1 12.5 3a8.5 8.5 0 0 1 8.5 8.5Z"/>',
        'eye' => '<path d="M2 12s4-7 10-7 10 7 10 7-4 7-10 7S2 12 2 12Z"/><circle cx="12" cy="12" r="3"/>',
        'arrow' => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
    ];
    $path = $icons[$name] ?? $icons['grid'];
    return '<svg class="ui-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $path . '</svg>';
}

public static function default_menu_photos(): array
{
    return [
        'Warung Bu Sari' => 'https://images.unsplash.com/photo-1707274860741-1320eda4ef52?auto=format&fit=crop&w=900&q=82',
        'Mie Ayam Pak Slamet' => 'https://images.unsplash.com/photo-1747317277795-0d601795682c?auto=format&fit=crop&w=900&q=82',
        'Warteg Sederhana' => 'https://images.unsplash.com/photo-1707274860723-52233290a977?auto=format&fit=crop&w=900&q=82',
        'Ayam Geprek Mas Dika' => 'https://images.unsplash.com/photo-1744968048879-2c79641429e4?auto=format&fit=crop&w=900&q=82',
        'Kopi Kenangan (Cab. Kampus)' => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?auto=format&fit=crop&w=900&q=82',
        'Es Teh Poci' => 'https://images.unsplash.com/photo-1596343540266-130b3dbb1158?auto=format&fit=crop&w=900&q=82',
        'Jus Buah Bu Wati' => 'https://images.unsplash.com/photo-1577680716097-9a565ddc2007?auto=format&fit=crop&w=900&q=82',
        'Susu Kedelai Pak Joko' => 'https://thumb.wikimedia.org/wikipedia/commons/thumb/5/5f/Soy_milk.jpg/500px-Soy_milk.jpg',
        'Cilok Pak Eko' => 'https://thumb.wikimedia.org/wikipedia/commons/thumb/2/27/Cilok.jpg/500px-Cilok.jpg',
        'Cireng Isi Mbak Yuni' => 'https://thumb.wikimedia.org/wikipedia/commons/thumb/4/45/Cireng_isi.jpg/960px-Cireng_isi.jpg',
        'Pisang Goreng Keju' => 'https://images.unsplash.com/photo-1576867917480-152bca50166e?auto=format&fit=crop&w=900&q=82',
        'Seblak Teh Neng' => 'https://images.unsplash.com/photo-1645696288939-e59ed5e3cfa2?auto=format&fit=crop&w=900&q=82',
    ];
}
public static function menu_photo_url(array|\ArrayAccess $tempat): string
{
    $foto = trim((string) ($tempat['foto'] ?? ''));
    if (preg_match('~^storage/menu/[A-Za-z0-9_-]+\.(?:jpg|jpeg|png|webp)$~i', $foto)) return asset($foto);
    if (preg_match('~^https://[^\s<>\"\']+$~i', $foto) || preg_match('~^assets/uploads/[a-f0-9]{24}\.(?:jpg|png|webp)$~', $foto)) {
        return str_starts_with($foto, 'https://') ? $foto : asset($foto);
    }
    $photos = self::default_menu_photos();
    if (isset($photos[$tempat['nama'] ?? ''])) return $photos[$tempat['nama']];
    $fallback = ['makanan' => 'Warung Bu Sari', 'minuman' => 'Es Teh Poci', 'jajan' => 'Cireng Isi Mbak Yuni'];
    return $photos[$fallback[$tempat['kategori'] ?? 'makanan'] ?? 'Warung Bu Sari'];
}


}
