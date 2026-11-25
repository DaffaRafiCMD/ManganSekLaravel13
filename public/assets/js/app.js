(function () {
  'use strict';

  // Dialog detail promo
  document.querySelectorAll('[data-open-dialog]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var dlg = document.getElementById(btn.getAttribute('data-open-dialog'));
      if (dlg && typeof dlg.showModal === 'function') dlg.showModal();
    });
  });
  document.querySelectorAll('dialog').forEach(function (dlg) {
    dlg.addEventListener('click', function (e) { if (e.target === dlg) dlg.close(); });
    dlg.querySelectorAll('[data-close-dialog]').forEach(function (b) {
      b.addEventListener('click', function () { dlg.close(); });
    });
  });

  // Konfirmasi sebelum menghapus
  document.querySelectorAll('form[data-confirm]').forEach(function (form) {
    form.addEventListener('submit', function (e) {
      if (!window.confirm(form.getAttribute('data-confirm'))) e.preventDefault();
    });
  });

  // Tutup menu pengguna saat klik di luar
  document.addEventListener('click', function (e) {
    document.querySelectorAll('details.user-menu[open]').forEach(function (d) {
      if (!d.contains(e.target)) d.removeAttribute('open');
    });
  });

  // Pesan sukses hilang sendiri setelah beberapa detik
  var ok = document.querySelector('.flash-success');
  if (ok) setTimeout(function () { ok.remove(); }, 5000);

  // Tombol lihat/sembunyikan password pada portal login.
  document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var field = document.getElementById(btn.getAttribute('data-toggle-password'));
      if (!field) return;
      var visible = field.type === 'password';
      field.type = visible ? 'text' : 'password';
      btn.textContent = visible ? 'Tutup' : 'Lihat';
      btn.setAttribute('aria-label', visible ? 'Sembunyikan password' : 'Tampilkan password');
    });
  });

  // Pratinjau URL foto / unggahan pada form CRUD admin.
  var photoUrl = document.getElementById('foto');
  var photoFile = document.getElementById('foto-upload');
  var photoPreview = document.getElementById('foto-preview');
  if (photoPreview && photoUrl && photoFile) {
    var previewRoot = photoPreview.closest('.menu-photo-preview');
    var savedSrc = photoPreview.getAttribute('src');
    var objectUrl = null;
    var showPhoto = function (src) {
      photoPreview.hidden = false;
      previewRoot.classList.remove('no-photo');
      photoPreview.src = src || savedSrc;
    };
    photoPreview.addEventListener('error', function () {
      photoPreview.hidden = true;
      previewRoot.classList.add('no-photo');
    });
    photoUrl.addEventListener('input', function () {
      if (!photoFile.files || !photoFile.files.length) showPhoto(photoUrl.value.trim());
    });
    photoFile.addEventListener('change', function () {
      if (objectUrl) URL.revokeObjectURL(objectUrl);
      objectUrl = null;
      if (photoFile.files && photoFile.files[0]) {
        objectUrl = URL.createObjectURL(photoFile.files[0]);
        showPhoto(objectUrl);
      } else showPhoto(photoUrl.value.trim());
    });
  }

  // Validasi kecocokan password di halaman daftar
  var pw = document.getElementById('password');
  var konfirmasi = document.getElementById('konfirmasi');
  if (pw && konfirmasi) {
    var cek = function () {
      konfirmasi.setCustomValidity(konfirmasi.value && konfirmasi.value !== pw.value
        ? 'Konfirmasi password harus sama dengan password.' : '');
    };
    pw.addEventListener('input', cek);
    konfirmasi.addEventListener('input', cek);
  }
})();
