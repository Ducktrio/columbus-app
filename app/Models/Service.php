<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->id)) {
                $service->id = self::generateId();
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
            $lastNumber = (int) str_replace('SVC_', '', $lastId);
            $newNumber = $lastNumber + 1;
        }
        return 'SVC_' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'name',
        'price'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function serviceTickets()
    {
        return $this->hasMany(ServiceTicket::class, 'service_id');
    }
}
