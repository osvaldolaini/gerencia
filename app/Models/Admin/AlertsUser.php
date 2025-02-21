<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertsUser extends Model
{
    protected $table = 'alerts_users';

    protected $fillable = [
        'active',
        'see',
        'alert_id',
        'user_id',
        'updated_by',
        'created_by',
        'deleted_at',
        'deleted_by'
    ];
    /**
     * Get the alerts that owns the AlertsUser
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function alert(): BelongsTo
    {
        return $this->belongsTo(Alerts::class, 'alert_id', 'id');
    }
}
