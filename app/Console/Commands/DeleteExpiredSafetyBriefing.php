<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SafetyBriefingInfo;
use Carbon\Carbon;

class DeleteExpiredSafetyBriefing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DeleteExpiredSafetyBriefing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // $oneMonthAgo = Carbon::now()->subMonth();

        $yesterday = Carbon::yesterday();
        
        SafetyBriefingInfo::where('briefingDate', '<', $yesterday)->delete();

        $this->info('Old safety briefing records deleted successfully.');
    }
}
