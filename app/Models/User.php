<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserGroups;
use App\Models\Admin\AlertsUser;
use App\Models\Admin\Registrations\Enrollments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'active',
        'name',
        'email',
        'password',
        'groups',
        'accesses',
        'activities',
        'panel',
        'dark',
        'cpf_cnpj',
        'see_excluded'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function hasCommonAccessWith($user)
    {
        return count(
            array_intersect(
                $this->jsonGroups,
                $user->jsonGroups
            )
        ) > 0;
    }
    public function getGroupsOfUser(): array
    {
        return array_map(fn($level) => UserGroups::from($level), $this->jsonGroups);
    }
    // public function getSeeExcludedAttribute()
    // {
    //     if ($this->see_excluded) {
    //         return true;
    //     } else {
    //         return false;
    //     }
    // }
    public function getJsonGroupsAttribute()
    {
        return json_decode($this->groups);
    }
    public function getTitleAttribute()
    {
        return $this->name . $this->cpf_cnpj ?? ' (' . $this->cpf_cnpj . ')';
    }
    public function setGroupsAttribute($value)
    {
        $this->attributes['groups'] = json_encode($value);
    }
    public function getJsonAccessesAttribute()
    {
        return json_decode($this->accesses);
    }
    public function setAccessesAttribute($value)
    {
        $this->attributes['accesses'] = json_encode($value);
    }
    public function getJsonActivitiesAttribute()
    {
        return json_decode($this->activities);
    }
    public function setActivitiesAttribute($value)
    {
        $this->attributes['activities'] = json_encode($value);
    }
    public function getPanelIdAttribute()
    {
        switch ($this->panel) {
            case 'admin':
                return 1;
                break;
            case 'user':
                return 2;
                break;
            default:
                return 2;
                break;
        }
        return json_decode($this->accesses);
    }

    public function getRedirectRoute(): string
    {
        return match ((int)$this->panelId) {
            1 => '/admin/dashboard',
            2 => 'app',
        };
    }
    public function alerts()
    {
        return $this->hasMany(AlertsUser::class, 'user_id', 'id');
    }
}
