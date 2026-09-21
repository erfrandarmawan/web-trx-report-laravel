<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\TransactionFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /** @use HasFactory<TransactionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'amount',
        'trx_date',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    /**
     * @return Attribute<Carbon, Carbon>
     */
    protected function trxDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value): Carbon => Carbon::parse($value)->setTimezone($this->localTimezone()),
            set: fn ($value): Carbon => Carbon::parse($value, $this->localTimezone())->utc(),
        );
    }

    private function localTimezone(): string
    {
        return config('app.local_timezone', 'Asia/Jakarta');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
