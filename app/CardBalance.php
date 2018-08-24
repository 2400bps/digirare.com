<?php

namespace App;

use Cache;
use App\Card;
use Droplister\XcpCore\App\Balance;
use Tightenco\Parental\HasParentModel;

class CardBalance extends Balance
{
    use HasParentModel;

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope(function ($query) {
            $query->cards();
        });
    }

    /**
     * Collector
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function collector()
    {
        return $this->belongsTo(Collector::class, 'address', 'xcp_core_address');
    }

    /**
     * Card
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function card()
    {
        return $this->belongsTo(Card::class, 'asset_name', 'xcp_core_asset_name');
    }

    /**
     * Game Tokens
     */
    public function scopeCards($query)
    {
        $cards = Cache::remember('cards', 1440, function () {
            return Card::pluck('xcp_core_asset_name');
        });

        return $query->whereIn('asset', $cards);
    }
}