<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:hitung-denda')]
#[Description('Command description')]
class HitungDenda extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now();

        $data = \App\Models\Peminjaman::whereIn('status', ['dipinjam', 'request_kembali'])->get();

        foreach ($data as $item) {

            if ($today->gt($item->tanggal_kembali)) {

                $hari = $item->tanggal_kembali->diffInDays($today);
                $denda = $hari * 5000;

                $item->update([
                    'denda' => $denda,
                    'status_pembayaran' => 'belum_bayar'
                ]);
            }
        }

        return 0;
    }
}
