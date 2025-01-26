<?php

namespace App\Console\Commands;

use App\Models\Contract;
use App\Models\User;
use App\Notifications\ContractGarantie;
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
        $users = User::where('Type', 'admin')
                ->orWhere('Type', 'worker')
                ->get();
        foreach ($equipment as $item) {
            foreach ($users as $user) {
                // Notify user
                $user->notify(new ContractGarantie($item));
            }

            $item->notified = true ;
            // Mark the equipment as notified
            $item->update();
        }

        $this->info('Notifications sent successfully.');
    }
}
