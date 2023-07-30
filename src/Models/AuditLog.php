<?php

namespace Asif\LaravelModelLogs\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = ['action', 'model_type', 'model_id', 'old_values', 'new_values', 'user_id'];
}
