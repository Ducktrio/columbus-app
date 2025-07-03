<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $table = 'room_types';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($roomType) {
            if (empty($roomType->id)) {
                $roomType->id = self::generateId();
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
            $lastNumber = (int) str_replace('RT_', '', $lastId);
            $newNumber = $lastNumber + 1;
        }
        return 'RT_' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }
}
