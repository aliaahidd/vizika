<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SafetyBriefingInfo;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class GenerateSafetyBriefingSlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-safety-briefing-slots';

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
        $startDate = now()->addDay(); // Start generating slots from tomorrow
        $endDate = now()->addMonths(1);

        while ($startDate <= $endDate) {
            if (!$startDate->isWeekend()) {
                // create briefing info

                $data = array(
                    'briefingDate' => $startDate,
                    'briefingTimeStart' => "09:00:00",
                    'briefingTimeEnd' => "11:00:00",
                    'maxParticipant' => 30,
                    'briefingStatus' => "Active",
                );

                // insert query 9 - 11 am
                DB::table('safetybriefinginfo')->insert($data);

                $data2 = array(
                    'briefingDate' => $startDate,
                    'briefingTimeStart' => "15:00:00",
                    'briefingTimeEnd' => "17:00:00",
                    'maxParticipant' => 30,
                    'briefingStatus' => "Active",
                );

                // insert query 3- 5 pm
                DB::table('safetybriefinginfo')->insert($data2);
            }

            $startDate->addDay(); // Move to the next day
        }

        $this->info('Safety briefing slots generated successfully.');
    }
}
