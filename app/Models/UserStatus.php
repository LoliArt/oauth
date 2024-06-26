<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserStatus extends Model
{
    protected $fillable = [
        'text',
        'user_id',
    ];

    protected $casts = [
        'text' => 'string',
        'user_id' => 'integer',
    ];

    protected $hidden = [
        'id',
        'user_id',
        'updated_at',
    ];

    // 默认 const
    public const DEFAULT = [
        'text' => null,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->select(['id', 'name', 'email_md5']);
    }
}
