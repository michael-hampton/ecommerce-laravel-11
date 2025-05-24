<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Notification;
use Spatie\PersonalDataExport\ExportsPersonalData;
use Spatie\PersonalDataExport\PersonalDataSelection;

class User extends Authenticatable implements CanResetPassword, MustVerifyEmail, ExportsPersonalData
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'mobile',
        'image',
        'utype',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean',
    ];

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'commentable');
    }

    public function postedReviews(): HasMany
    {
        return $this->hasMany(Review::class, 'user_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function defaultAddress(): ?Address
    {
        return $this->hasOne(Address::class, 'customer_id', 'id')->first();
    }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class, 'user_id');
    }

    public function notificationTypes(): HasMany
    {
        return $this->hasMany(UserNotification::class, 'user_id');
    }

    public function selectPersonalData(PersonalDataSelection $personalDataSelection): void
    {
        $personalDataSelection
            ->add('user.json', [
                'name' => $this->name,
                'email' => $this->email,
                'utype' => $this->utype,
                'mobile' => $this->mobile,
                'city' => $this->profile->city,
                'state' => $this->profile->state,
                'zip' => $this->profile->zip,
                'address1' => $this->profile->address1,
                'address2' => $this->profile->address2,
                'phone' => $this->profile->phone,
                'website' => $this->profile->website,
                'shop_name' => $this->profile->name,
                'shop_email' => $this->profile->email,
                'date_of_birth' => $this->profile->date_of_birth,
                'biography' => $this->profile->biography
            ]);
            //->addFile(asset("images/users/{$this->image}"))
            //->addFile(asset("images/sellers/{$this->profile->profile_picture}"));
        ;
    }

    public function personalDataExportName(): string
    {
        $userName = Str::slug($this->name);

        return "{$this->id}_personal-data-{$userName}.zip";
    }
}
