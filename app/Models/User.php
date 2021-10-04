<?php

namespace App\Models;

use App\Repositories\WalletRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'phone_number', 'email', 'password', 'role', 'reference_id', 'district_id', 'designation_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function (User $user){

            $callback = function (User $createdUser, User $reference) use(&$callback){

                $latestDepth = $reference->childs()->orderBy('pivot_depth', 'desc')->first();

                $createdUser->parents()->attach([
                    $reference->id => [
                        'depth' => ($latestDepth ? ($latestDepth->pivot->depth + 1) : 1)
                    ]
                ]);

                if($reference->hasReference()){

                    $callback($createdUser, $reference->parent);
                }
            };

            $designationUpdater = function (User $user, User $reference) use(&$designationUpdater){
                if($reference->hasReference()){
                    $reference->updateDesignation();

                    $designationUpdater($user, $reference->parent);
                }
            };

            if($user->hasReference()){
                $callback($user, $user->parent);

                $user->update([
                    'designation_id' => PromotionalDesignation::default()->first()->id ?? null,
                    'role' => 'unregistered'
                ]);

                $designationUpdater($user, $user->parent);
            }
        });
    }

    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function wishlistProducts()
    {
        return $this->morphedByMany(Product::class, 'listable', 'user_wishlists', 'user_id');
    }

    public function wishlistPackages()
    {
        return $this->morphedByMany(Package::class, 'listable', 'user_wishlists', 'user_id');
    }

    public function metas()
    {
        return $this->hasMany(UserMeta::class);
    }

    public function getMetaAttribute()
    {
        return $this->metas->meta();
    }


    // Reference Relation or Helpers Methods

    public function parents()
    {
        return $this->belongsToMany(User::class, 'reference_trees', 'user_id', 'parent_id')
            ->withPivot('depth');
    }

    public function childs()
    {
        return $this->belongsToMany(User::class, 'reference_trees', 'parent_id', 'user_id')
            ->withPivot('depth');
    }

    public function hasReference()
    {
        return $this->reference_id;
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'reference_id');
    }

    // Wallets

    public function wallets()
    {
        return $this->hasMany(Wallet::class);
    }

    public function hasBalance($balance)
    {
        return (new WalletRepository())->presentWalletAmount() >= $balance;
    }

    // Roles
    public function isRegisteredMember()
    {
        return $this->role == 'registered';
    }

    // Orders

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function designation()
    {
        return $this->belongsTo(PromotionalDesignation::class, 'designation_id');
    }

    public function scopeRegistered(Builder $builder)
    {
        $builder->where('role', 'registered');
    }

    public function scopeUnRegistered(Builder $builder)
    {
        $builder->where('role', 'unregistered');
    }

    protected function updateDesignation()
    {
        $promotedDesignation = PromotionalDesignation::where('required_designation_id', $this->designation->id)->first();

        if(!$promotedDesignation){
            return;
        }

        $designationCount = $this->childs()->whereHas('designation', function ($query) use ($promotedDesignation){
            $query->where('id', $promotedDesignation->required_designation_id);
        })->count();


        if($designationCount == $promotedDesignation->required_designation){

            $this->update([
                'designation_id' => $promotedDesignation->id
            ]);
        }
    }

    public function conversations()
    {
        return $this->belongsToMany(Conversation::class)
            ->using(UserConversation::class);
    }

}
