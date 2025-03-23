<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
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
}
