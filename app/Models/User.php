<?php

namespace App\Models;

use App\Models\DeskStatus\DeskStatusModel;
use App\Models\Log\LogModel;
use App\Models\OfficeStatus\OfficeStatusModel;
use App\Traits\UserTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Permission\Traits\HasRoles;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable implements HasMedia {
    use HasFactory, Notifiable, SoftDeletes, HasRoles, InteractsWithMedia, UserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'address',
        'dob',
        'email',
        'phone',
        'password',
        'status',
        'verification_status',
        'avatar_path',

        // 'designation',
        // 'contact_number',
        // 'employee_code',
        // 'employee_department',
        // 'desk_status',
        // 'office_status',
        // 'remarks'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * defaining media/file collection
     *
     * @return void
     */
    public function registerMediaCollections(): void {
        //photos
        $this->addMediaCollection($this->userProfileImageCollection)->singleFile();
        $this->addMediaCollection($this->userIdVerificationImageCollection)->singleFile();
    }

    // //office status
    // public function officeStatus() {
    //     return $this->hasMany(OfficeStatusModel::class, 'user_id', 'id');
    // }

    // //desk status
    // public function deskStatus() {
    //     return $this->hasMany(DeskStatusModel::class, 'user_id', 'id');
    // }

    // //log
    // public function logs() {
    //     return $this->hasMany(LogModel::class, 'user_id', 'id');
    // }

}
