<?php
//app/Notifications/LowStockNotification.php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LowStockNotification extends Notification {
    protected $items;
    public function __construct($items){ $this->items = $items; }

    public function via($notifiable){ return ['mail','database']; }

    public function toMail($notifiable){
        $count = $this->items->count();
        $mail = (new MailMessage)
            ->subject("Peringatan: $count item ATK stok rendah")
            ->line("Ada $count item yang mencapai threshold stok rendah. Cek sistem.");
        return $mail;
    }

    public function toArray($notifiable){
        return ['items'=>$this->items->map(fn($i)=>['id'=>$i->id,'code'=>$i->code,'stock'=>$i->stock])->toArray()];
    }
}
