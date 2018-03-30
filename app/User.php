<?php

namespace Corp;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'login', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function articles() {
        return $this->hasMany('Corp\Article');
    }

    public function portfolios() {
        return $this->hasMany('Corp\Portfolio');
    }

    public function roles() {
        return $this->belongsToMany('Corp\Role','role_user');
    }

    // $permission может быть string  or array('VIEW_ADMIN','ADD_ARTICLES', etc.)
    // arg[$require] актуален только когда $permission - массив
    public function canDo($permission, $require = FALSE) {
        if (is_array($permission)) {
            foreach ($permission as $permName) {
                $permName = $this->canDo($permName);
                if ($permName && !$require) {
                    return TRUE;
                } else if(!$permName && $require) {
                    return FALSE;
                }
            }
            return $require;
        } else {
            foreach($this->roles as $role) {
                foreach($role->perms as $perm) {
                    // foo*   foobar  , т.е. маска - образец
                    if (str_is($permission, $perm->name)) {
                        return TRUE;
                    }
                }
            }
        }
    }

    public function hasRole($name, $require = FALSE) {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                
                $hasRole = $this->hasRole($roleName);
                if ($hasRole && !$require) {
                    return TRUE;
                } else if(!$hasRole && $require) {
                    return FALSE;
                }
            }
            return $require;
        } else {
            foreach($this->roles as $role) {
                if ($role->name == $name) {
                    return TRUE;
                }
            }
        }
    }

}
