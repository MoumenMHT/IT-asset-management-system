<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EquipmentAmortizationReminder extends Notification
{
    use Queueable;
    protected $equipment;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($equipment)
    {
        $this->equipment = $equipment;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // Store notification in the database
    }

    
    public function toDatabase($notifiable)
    {

        return [
            'message' => 'The equipment "' . $this->equipment->num_serie . '" is nearing its amortization date.',
            'num_serie' => $this->equipment->num_serie,
            'equipment_id' => $this->equipment->id_equipement,
            'date_amortissement' => $this->equipment->date_amortissement,
        ];
    }

    
}
