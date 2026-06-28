<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransLaundryPickup extends Model
{
    protected $table = 'trans_laundry_pickup';
    
    protected $fillable = [
        'id_order',
        'id_customer',
        'pickup_date',
        'notes'
    ];

    // Penjelasan: Relasi ke tabel order
    public function order()
    {
        return $this->belongsTo(TransOrder::class, 'id_order');
    }

    // Penjelasan: Relasi ke tabel customer
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id_customer')->withTrashed();
    }
}
