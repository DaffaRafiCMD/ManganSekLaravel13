
    <article class="card">
      <div class="card-img">
        <img src="{{ \App\Support\ManganSekView::menu_photo_url($t) }}" alt="Foto ilustrasi {{ $t['nama'] }}" loading="lazy" decoding="async" referrerpolicy="no-referrer" onerror="this.hidden=true;this.parentElement.classList.add('no-photo')">
        <span class="photo-placeholder">{!! \App\Support\ManganSekView::ui_icon('image') !!} Foto belum tersedia</span>
      </div>
      @if (auth()->check() && !auth()->user()?->isAdmin())
        <form method="post" action="{{ route('favorit.toggle',$t) }}" class="fav-form">
          @csrf
          <button type="submit" class="fav-btn{{ in_array((int)$t->id, array_map('intval',$favoritIds ?? []), true) ? ' is-fav' : '' }}"
                  aria-pressed="{{ in_array((int)$t->id, array_map('intval',$favoritIds ?? []), true) ? 'true' : 'false' }}"
                  aria-label="{{ in_array((int)$t->id, array_map('intval',$favoritIds ?? []), true) ? 'Hapus dari favorit' : 'Tambah ke favorit' }}: {{ $t['nama'] }}">{!! \App\Support\ManganSekView::ui_icon('heart') !!}</button>
        </form>
      @endif
      <div class="card-body">
        <h3 class="card-title">{{ $t['nama'] }}</h3>
        <p class="card-meta">{!! \App\Support\ManganSekView::ui_icon('pin') !!} {{ number_format((float) $t['jarak_km'], 1) }} km</p>
        <p class="card-price">{{ \App\Support\ManganSekView::harga_range($t) }}</p>
        <p class="card-meta">{!! \App\Support\ManganSekView::ui_icon('star') !!} {{ number_format((float) $t['rating'], 1) }} ({{ (int) $t['ulasan'] }} ulasan)</p>
        <span class="pill">{{ $t['jenis'] }}</span>
        @if (auth()->user()?->isAdmin())
          <div class="menu-card-admin-actions"><a class="btn btn-outline btn-sm" href="{{ route('menu.edit',$t) }}">Edit Menu</a><form method="post" action="{{ route('menu.destroy',$t) }}" data-confirm="Hapus {{ $t['nama'] }} beserta seluruh reviewnya?">@csrf @method('DELETE')<button class="btn btn-danger btn-sm" type="submit">Hapus</button></form></div>
        @endif
        @if ($showReview)
          <a class="btn {{ (auth()->check() && !auth()->user()->isAdmin()) ? 'btn-primary' : 'btn-outline' }} btn-review" href="{{ route('review.index',$t) }}">{{ (auth()->check() && !auth()->user()->isAdmin()) ? 'Tulis Review' : 'Lihat Ulasan' }}</a>
        @endif
      </div>
    </article>
    