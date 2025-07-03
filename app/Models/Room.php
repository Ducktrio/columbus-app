<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table = 'rooms';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->id)) {
                $room->id = self::generateId();
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
            $lastNumber = (int) str_replace('RM_', '', $lastId);
            $newNumber = $lastNumber + 1;
        }
        return 'RM_' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'label',
        'room_type_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function roomTickets()
    {
        return $this->hasMany(RoomTicket::class, 'room_id');
    }

    public function serviceTickets()
    {
        return $this->hasMany(ServiceTicket::class, 'room_id');
    }
}
