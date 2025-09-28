<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Comment;
use Illuminate\Support\Facades\Log;

class DeleteComment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-comment';

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
        $countComment = Comment::count();
        Comment::where('created_at', '<=', now()->subMinutes(3))->delete();
        Log::info('comments deleted',['total count' => $countComment]);
    }
}
