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
            'message' => 'The equipment "' . $this->contract->ref . '" is nearing its amortization date.',
            'garantie' => $this->contract->garantie,
        ];
    }
}
