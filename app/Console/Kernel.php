<?php

namespace App\Console;

use App\Model\Invoice;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('inspire')
//                  ->hourly();

        $schedule->call(function () {
            $obj = new Invoice();
            $obj->crm_id = '1111111111111111111';
            $obj->business_name = '1111111111111111111';
            $obj->customer_name = '1111111111111111111';
            $obj->ticket_name = '1111111111111111111';
            $obj->tax_num = '1111111111111111111';
            $obj->address = '1111111111111111111';
            $obj->mobile = '1111111111111111111';
            $obj->money = '1111111111111111111';
            $obj->ticket_day = '1111111111111111111';
            $obj->ticket_month = '1601510400';
            $obj->save();
        })->everyMinute();

//        $schedule->call(function () {
//            $tmp = Invoice::all();
//            $tmp = DB::table('invoice')->get();
//            dump($tmp);
//        })->everyMinute();

//        $schedule->call(
//            'App\Http\Controllers\Admin\InvoiceController@planTask'
//        )->everyMinute();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
