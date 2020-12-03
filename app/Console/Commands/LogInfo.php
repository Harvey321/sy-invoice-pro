<?php

namespace App\Console\Commands;

use App\Model\Invoice;
use Illuminate\Console\Command;

class LogInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lesson:log';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Log Info';

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
     * @return mixed
     */
    public function handle()
    {
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
    }
}
