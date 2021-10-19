<?php

namespace App\Console\Commands;

use App\Models\DailyActivity;
use App\Models\DataProcessingControl;
use App\Models\Registro;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class ProcessDailyActivyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'activity:process {--date=none}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $current = Carbon::now();
        Log::info("procesando data ");
        $dateInput = $this->option('date') == 'none' ?  ($current)->format('Y-m-d') : (new Carbon($this->option('date')))->format('Y-m-d');
        $day = new Carbon($dateInput);
        $groups = Registro::select('username', 'hostname')->day($day)->groupBy('username', 'hostname')->get();
        $date = ($day)->format('Y-m-d');
        DailyActivity::day($day)->delete();

        $groups->each(function ($group) use ($date, $day) {
            $errors = 0;
            $report = DataProcessingControl::whereDate('day', '=', $date)->first();

            if (!$report) {
                $report = new DataProcessingControl(['day' => $date]);
                $report->save();
            }

            $userresume = Registro::day($day)->where('username', '=', $group->username)->where('hostname', '=', $group->hostname)->get();

            $dateStart = $userresume->first() ? $userresume->first()->createdAt : null;
            $last_type = null;

            $timeAcum = 0;
            foreach ($userresume as $key => $regist) {
                /**
                 *
                 * REGIST, DISCONNECT ,AWAY ,RETURN
                 */
                if ($regist->type == 'REGIST') {
                    $dateStart = $regist->createdAt;
                    $last_type = $regist->type;
                    continue;
                }

                if ($regist->type == 'AWAY') {

                    $timeAcum += $regist->createdAt->diffInSeconds($dateStart);
                    $dateStart = $regist->createdAt;
                    $last_type = $regist->type;

                    continue;
                }

                if ($regist->type == 'RETURN') {
                    if ($last_type != 'AWAY') {
                        $errors++;
                        $report->save();
                    }
                    $dateStart = $regist->createdAt;
                    $last_type = $regist->type;
                    continue;
                }

                if ($regist->type == 'DISCONNECT') {
                    $timeAcum += $regist->createdAt->diffInSeconds($dateStart);
                    $dateStart = $regist->createdAt;
                    $last_type = $regist->type;
                }
            }

            $daily = new DailyActivity([
                'username' => $group->username,
                'hostname' => $group->hostname,
                'online_time' => $timeAcum,
                'errors' => $errors
            ]);

            if ($daily->save()) {
                $report->state = true;
                $report->save();
            }
        });
        return Command::SUCCESS;
    }
}