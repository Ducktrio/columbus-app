<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTicket extends Model
{
    protected $table = 'ticket_services';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ticketService) {
            if (empty($ticketService->id)) {
                $ticketService->id = self::generateId();
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
        'service_id',
        'room_id',
        'customer_id',
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
