<?php

namespace App\Models;

use App\Filament\Resources\ConferenceIssueResource;
use App\Models\Conference;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConferenceIssue extends Model
{
    use HasFactory;

    public const REASONS = [
        'duplicate',
        'incorrect',
        'spam',
        'other',
    ];

    protected $guarded = [];

    public static function reasonOptions()
    {
        return collect(static::REASONS)->map(function ($reason) {
            return [
                'value' => $reason,
                'text' => __("conference.issues.{$reason}"),
            ];
        });
    }

    public function conference(): BelongsTo
    {
        return $this->belongsTo(Conference::class)
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeWhereOpen($query)
    {
        $query->whereNull('closed_at');
    }

    public function getDescriptionAttribute()
    {
        return __("conference.issues.{$this->reason}");
    }

    public function getLinkAttribute()
    {
        return ConferenceIssueResource::getUrl('view', $this);
    }

    public function isOpen()
    {
        return ! $this->closed_at;
    }

    public function close(User $by, $note)
    {
        $this->update([
            'closed_by' => $by->id,
            'admin_note' => $note,
            'closed_at' => now(),
        ]);
    }
}
