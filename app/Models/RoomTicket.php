<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTicket extends Model
{
    protected $table = 'room_tickets';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($roomTicket) {
            if (empty($roomTicket->id)) {
                $roomTicket->id = self::generateId();
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
            $lastNumber = (int) str_replace('TKTRM_', '', $lastId);
            $newNumber = $lastNumber + 1;
        }
        return 'TKTRM_' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'customer_id',
        'room_id',
        'check_in_date',
        'check_out_date',
        'number_of_occupants',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
