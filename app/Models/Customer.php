<?php

namespace App\Models;

use Illuminate\Contracts\Pipeline\Hub;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int $store_id
 * @property string $first_name
 * @property string $phone
 * @property string $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $last_login_at
 */
class Customer extends Model
{

    use SoftDeletes;

    protected $fillable = ['has_optin'];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }




}
