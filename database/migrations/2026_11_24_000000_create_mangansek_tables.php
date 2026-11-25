<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        // Khusus database kosong; jangan baseline database lama dengan migration ini.
        foreach (['users','tempat','review','favorit','meal_hack','promo'] as $name) {
            if (Schema::hasTable($name)) throw new RuntimeException('Gunakan database kosong untuk migration ManganSek. Tabel '.$name.' sudah ada.');
        }
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama',100); $table->string('email',150)->unique();
            $table->string('telepon',20)->nullable(); $table->string('password');
            $table->enum('role',['user','admin'])->default('user');
            $table->dateTime('created_at')->useCurrent();
        });
        Schema::create('tempat', function (Blueprint $table) {
            $table->increments('id'); $table->string('nama',100);
            $table->enum('kategori',['makanan','minuman','jajan'])->index();
            $table->string('jenis',30); $table->decimal('jarak_km',4,1)->default(0);
            $table->unsignedInteger('harga_min')->default(0); $table->unsignedInteger('harga_max')->default(0);
            $table->string('foto',2048)->default(''); $table->decimal('rating_dasar',3,1)->default(0);
            $table->unsignedInteger('ulasan_dasar')->default(0); $table->boolean('rekomendasi')->default(false);
            $table->unsignedInteger('dibuat_oleh')->nullable();
            $table->foreign('dibuat_oleh')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::create('review', function (Blueprint $table) {
            $table->increments('id'); $table->unsignedInteger('tempat_id'); $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('rating'); $table->string('komentar',500); $table->dateTime('created_at')->useCurrent();
            $table->foreign('tempat_id')->references('id')->on('tempat')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create('favorit', function (Blueprint $table) {
            $table->increments('id'); $table->unsignedInteger('user_id'); $table->unsignedInteger('tempat_id');
            $table->dateTime('created_at')->useCurrent(); $table->unique(['user_id','tempat_id']);
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('tempat_id')->references('id')->on('tempat')->cascadeOnDelete()->cascadeOnUpdate();
        });
        Schema::create('meal_hack', function (Blueprint $table) {
            $table->increments('id'); $table->unsignedInteger('user_id')->nullable();
            $table->string('judul',100); $table->string('deskripsi',255); $table->unsignedInteger('hemat')->default(0); $table->string('ikon',30)->default('lightbulb');
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
        });
        Schema::create('promo', function (Blueprint $table) {
            $table->increments('id'); $table->string('judul',100); $table->string('warna',30); $table->string('nama_tempat',120);
            $table->enum('kategori',['makanan','minuman','jajan']); $table->string('deskripsi',255); $table->string('syarat',255); $table->date('berlaku_sampai');
        });
    }
    public function down(): void {
        foreach (['promo','meal_hack','favorit','review','tempat','users'] as $name) Schema::dropIfExists($name);
    }
};
