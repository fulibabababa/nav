<?php

namespace App\Console;

use App\Models\Link;
use GuzzleHttp\Psr7\Response;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Str;
use QL\QueryList;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function () {
            $links = Link::other()->inPending()->get();
            $this->checkFriend($links);
        })->cron('*/'.config('protect.crontab.check_pending_per_time').' * * * *');

        $schedule->call(function () {
            $links = Link::other()->inSuccess()->get();
            $this->checkFriend($links);
        })->cron('*/'.config('protect.crontab.check_success_per_time').' * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    protected function checkFriend($links)
    {
        $urls = $links->pluck('link');
        if ($urls->isEmpty()) {
            return true;
        }

        QueryList::multiGet($urls->toArray())
            ->concurrency(5)
            // 设置GuzzleHttp的一些其他选项
            ->withOptions([
                'timeout' => 60
            ])
            ->success(function (QueryList $ql, Response $response, $index) use ($links) {
                $link = $links[$index];
                echo $link->web_name;

                $text = $ql->find('a[href="http://nav.showtime.test"]')->text();
                if (empty($text) || !Str::contains($text, '可儿福利导航')) {
                    if ($link->isOverMaxFailure()) {
                        $link->status = Link::STATUS_BLACKLIST;
                    } else {
                        $link->increment('failure_times');
                    }
                } else {
                    $link->status = Link::STATUS_SUCCESS;
                }
                $link->save();
            })
            ->error(function (QueryList $ql, $reason, $index) use ($links) {
                $link = $links[$index];
                echo $link->web_name;

                if ($link->isOverMaxFailure()) {
                    $link->status = Link::STATUS_BLACKLIST;
                } else {
                    $link->increment('failure_times');
                }

                $link->save();
            })
            ->send();

        return true;
    }

}
