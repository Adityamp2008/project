<?php

// app/Console/Commands/CheckLowStock.php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Models\AtkItem;
use App\Notifications\LowStockNotification;
use App\Models\User;

class CheckLowStock extends Command {
    protected $signature = 'atk:check-low-stock';
    protected $description = 'Cek ATK dengan stok di bawah threshold dan notifikasi.';
    public function handle(){
        $low = AtkItem::whereColumn('stock','<=','low_stock_threshold')->get();
        if ($low->isEmpty()) return $this->info('No low stock.');
        // kirim notifikasi ke semua user dengan role admin/petugas
        $users = User::whereIn('role',['admin','petugas'])->get();
        foreach($users as $u) $u->notify(new LowStockNotification($low));
        $this->info('Notifications sent to '. $users->count());
    }
}
