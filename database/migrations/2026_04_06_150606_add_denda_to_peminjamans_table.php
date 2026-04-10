<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->integer('denda')->default(0)->after('status');
            $table->string('status_pembayaran')->nullable()->after('denda');
        });
    }

    public function down()
    {
        Schema::table('peminjamans', function (Blueprint $table) {
            $table->dropColumn(['denda', 'status_pembayaran']);
        });
    }
};