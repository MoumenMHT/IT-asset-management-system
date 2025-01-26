<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
 
class ContractGarantie extends Notification
{
    use Queueable;

    protected $contract;

    public function __construct($contract)
    {
        $this->contract = $contract;
    }

    public function via($notifiable)
    {
        return ['database']; // Store notification in the database
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'The contract "' . $this->contract->ref . '" is nearing its garantie date.',
            'date_amortissement' => $this->contract->garantie,
            'array' => $this->contract,
            'type' => 'contract',


        ];
    }
}
