<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Models\User;
use App\Notifications\EquipmentAmortizationReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
class NotifyAdminOfContractGarantie extends Command
{
    protected $signature = 'notify:contractGarantie';
    protected $description = 'Send notifications to admins about contract nearing end of garantie date';

    public function handle()
    {
        // Find equipment with amortization date one month from now and not notified
        $equipment = Contract::whereDate('garantie', '<=', Carbon::now()->addMonth()->toDateString())
            ->where('notified', false)
            ->get();

        if ($equipment->isEmpty()) {
            $this->info('No Contract nearing garantie end date.');
            return;
        }

        // Get all admin users
        $admins = User::where('type', 'admin')->get();

        foreach ($equipment as $item) {
            foreach ($admins as $admin) {
                // Notify admin
                $admin->notify(new EquipmentAmortizationReminder($item));
            }

            $item->notified = true ;
            // Mark the equipment as notified
            $item->update();
        }

        $this->info('Notifications sent successfully.');
    }
}
