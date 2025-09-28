<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class ClearOldData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-old-data';

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
        $twoDaysAgo = Carbon::now()->subDays(2);
        dd($twoDaysAgo);
        $twoMinuteAgo = Carbon::now()->subMinutes(2);
        DB::table('comments')->where('created_at', '<', $twoDaysAgo)->delete();
        //return $twoDaysAgo;
    }
}

//var_dump(ClearOldData::handle());
