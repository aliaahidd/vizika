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
    protected $signature = 'GenerateSafetyBriefingSlots';

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
                // Check if a record with the same date and time already exists
                $existingRecord = DB::table('safetybriefinginfo')
                    ->where('briefingDate', $startDate)
                    ->whereIn('briefingTimeStart', ['09:00:00', '15:00:00'])
                    ->whereIn('briefingTimeEnd', ['11:00:00', '17:00:00'])
                    ->first();

                if (!$existingRecord) {
                    // Create briefing info

                    // Insert query 9 - 11 am
                    $data = [
                        'briefingDate' => $startDate,
                        'briefingTimeStart' => "09:00:00",
                        'briefingTimeEnd' => "11:00:00",
                        'maxParticipant' => 30,
                        'briefingStatus' => "Active",
                    ];

                    DB::table('safetybriefinginfo')->insert($data);

                    // Insert query 3- 5 pm
                    $data2 = [
                        'briefingDate' => $startDate,
                        'briefingTimeStart' => "15:00:00",
                        'briefingTimeEnd' => "17:00:00",
                        'maxParticipant' => 30,
                        'briefingStatus' => "Active",
                    ];

                    DB::table('safetybriefinginfo')->insert($data2);
                }
            }

            $startDate->addDay(); // Move to the next day
        }

        $this->info('Safety briefing slots generated successfully.');
    }
}
