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
        'check_in',
        'check_out',
        'number_of_occupants',
    ];

    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    
    public function checkIn()
    {
        $this->check_in = now();
        $this->save();

        if ($this->room) {
            $this->room->status = 1;
            $this->room->save();
        }
    }

    public function checkOut()
    {
        $this->check_out = now();
        $this->status = 1;
        $this->save();

        if ($this->room) {
            $this->room->status = 2;
            $this->room->save();
        }

        ServiceTicket::create([
            'customer_id' => $this->customer_id,
            'room_id' => $this->room_id,
            'service_id' => Service::where('name', 'Cleaning')->first()->id,
            'details' => 'Room checkout cleaning service',
        ]);
    }
}
