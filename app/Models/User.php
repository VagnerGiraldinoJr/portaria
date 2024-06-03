<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kodeine\Acl\Traits\HasRole;

class User extends Authenticatable
{
    use Notifiable, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','unidade_id','role', 'desc_role'
    ];
    
    protected $appends = ['desc_role'];

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



    public function getDescRoleAttribute()
    {
        $role = new Role();
        $tmp_value = $role->select('name')->find($this->role);
        return ($tmp_value) ? $tmp_value['name'] : '';
    }

        public function unidade()
    {
        return $this->belongsTo(Unidade::class);
    }
}