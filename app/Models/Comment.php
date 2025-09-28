<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Prunable;

class Comment extends Model
{

    protected $fillable = ['comment', 'task_id', 'user_id'];

    use Prunable;

    public function creator(): BelongsTo
    {
        // Принадлежит пользователю
        // belongsTo определяется у модели содержащей внешний ключ
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo('App\Models\Task', 'task_id');
    }

    public function prunable(): Builder
    {
        return static::where('created_at', '<=', now()->subMinutes(2));
    }
}
