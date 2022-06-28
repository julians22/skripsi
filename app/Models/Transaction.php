<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELED = 'canceled';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the payment associated with the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'transaction_id', 'id');
    }

    /**
     * Get the parrent typeable model with the Transaction
     */
    public function typeable()
    {
        return $this->morphTo();
    }

    /**
     * Has the Transaction been paid?
     */
    public function isPaid(){
        return $this->status === self::STATUS_PAID;
    }

    /**
     * The model hasPayment
     */
    public function hasPayment(){
        return $this->payment !== null;
    }

}
