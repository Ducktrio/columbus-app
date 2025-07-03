<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($customer) {
            if (empty($customer->id)) {
                $customer->id = self::generateId();
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
            $lastNumber = (int) str_replace('C_', '', $lastId);
            $newNumber = $lastNumber + 1;
        }
        return 'C_' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'courtesy_title',
        'full_name',
        'age',
        'contact_info',
        'phone_number',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function serviceTickets()
    {
        return $this->hasMany(ServiceTicket::class, 'customer_id');
    }

    public function roomTickets()
    {
        return $this->hasMany(RoomTicket::class, 'customer_id');
    }
}
