<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTicket extends Model
{
    protected $table = 'service_tickets';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($serviceTicket) {
            if (empty($serviceTicket->id)) {
                $serviceTicket->id = self::generateId();
            }
        });

        static::updated(function ($serviceTicket) {
            if (
                $serviceTicket->isDirty('status') &&
                $serviceTicket->status == 2 &&
                $serviceTicket->service->name === 'Cleaning' &&
                $serviceTicket->details === 'Room checkout cleaning service'
            ) {
                if ($serviceTicket->room) {
                    $serviceTicket->room->status = 0;
                    $serviceTicket->room->save();
                }
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
            $lastNumber = (int) str_replace('TKTSVC_', '', $lastId);
            $newNumber = $lastNumber + 1;
        }
        return 'TKTSVC_' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'customer_id',
        'room_id',
        'service_id',
        'details',
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
