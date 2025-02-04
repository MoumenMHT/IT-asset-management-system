<?php

namespace App\Console\Commands;
use App\Models\Equipment;
use App\Models\User;
use App\Notifications\EquipmentAmortizationReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;


class NotifyAdminOfAmortization extends Command
{
    protected $signature = 'notify:amortization';
    protected $description = 'Send notifications to admins about equipment nearing amortization date';

    public function handle()
    {

        
        // Find equipment with amortization date one month from now and not notified
        $equipment = Equipment::whereDate('date_amortissement', '<=', Carbon::now()->addMonth()->toDateString())
            ->where('notified', false)
            ->get();

        if ($equipment->isEmpty()) {
            $this->info('No equipment nearing amortization date.');
            return;
        }

        // Get all admin users
        $users = User::where('Type', 'admin')
                ->orWhere('Type', 'worker')
                ->get();
        foreach ($equipment as $item) {
            foreach ($users as $user) {
                // Notify user
                $user->notify(new EquipmentAmortizationReminder($item));
            }

            $item->notified = true ;
            // Mark the equipment as notified
            $item->update();
        }

        $this->info('Notifications sent successfully.');
    }
}
