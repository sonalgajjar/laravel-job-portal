<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'actor_type', 'actor_id', 'actor_name',
        'action', 'description', 'ip_address',
    ];

    public static function record(string $actorType, int $actorId, string $actorName, string $action, string $description = ''): void
    {
        static::create([
            'actor_type'  => $actorType,
            'actor_id'    => $actorId,
            'actor_name'  => $actorName,
            'action'      => $action,
            'description' => $description,
            'ip_address'  => request()->ip(),
        ]);
    }
}
