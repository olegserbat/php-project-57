<?php

use App\Console\Commands\DeleteComment;
use App\Models\Comment;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

//Schedule::call(function () {
//    $date = Comment::count();
//    $date = $date."\n";
//    file_put_contents('/Users/oleg/IT/php-project-57/storage/temp.txt', $date, FILE_APPEND);
//})->everyMinute();

//Schedule::call(function () {
//    Comment::where('created_at', '<=', now()->subMinutes(3))->delete();
//})->everyMinute()->appendOutputTo('/Users/oleg/IT/php-project-57/storage/temp.txt');

//Schedule::command('model:prune')->everyMinute();
Schedule::command(DeleteComment::class)->everyMinute();
