<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status_id', 'created_by_id', 'assigned_to_id'];

    public function creator(): BelongsTo
    {
        // Принадлежит пользователю
        // belongsTo определяется у модели содержащей внешний ключ
        return $this->belongsTo('App\Models\User', 'created_by_id');
    }

    public function assign(): BelongsTo
    {
        // Принадлежит пользователю
        // belongsTo определяется у модели содержащей внешний ключ
        return $this->belongsTo('App\Models\User', 'assigned_to_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo('App\Models\TaskStatus', 'status_id');
    }

    public function labeles(): BelongsToMany
    {
        return $this->belongsToMany(Label::class, 'label_task', 'task_id', 'label_id');
    }
}
