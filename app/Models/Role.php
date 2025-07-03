<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($role) {
            if (empty($role->id)) {
                $role->id = self::generateId();
            }
        });
    }

    protected static function generateId(): string
    {
        $lastId = self::orderBy('id', 'desc')->value('id');
        if (!$lastId) {
            $newNumber = 1;
        }
        else {
            $lastNumber = (int) str_replace('R_', '', $lastId);
            $newNumber = $lastNumber + 1;
        }
        return 'R_' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'title',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
