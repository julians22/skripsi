<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sales extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['grand_total', 'status_label'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the status label of the Sales
     */
    public function getStatusLabelAttribute(){
        if ($this->hasTransaction()) {
            return $this->transaction->status;
        }
        return 'draft';
    }

    /**
     * Get all of the details for the Sales
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(SalesDetail::class, 'sales_id', 'id');
    }

    /**
     * Get the customer associated with the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

    /**
     * Scope a query to only include monthly transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMonthInYear($query, int $month = 0, int $year = 0): Builder
    {
        if ($month == 0) {
            $month = date('m');
        }

        if ($year == 0) {
            $year = date('Y');
        }

        return $query->whereMonth('created_at', $month)
            ->whereYear('created_at', $year);
    }

    /**
     * Scope a query to only include today transactions.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */

    public function scopeToday($query): Builder
    {
        return $query->whereDate('created_at', date('Y-m-d'));
    }

    //get grand total
    public function getGrandTotalAttribute()
    {
        if ($this->discount > 0) {
            $total = $this->total - $this->discount;
            return $total;
        }

        return $this->total;
    }

    /**
     * Scope a query to search by customer name.
     * @param  \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeCustomerName($query, $name): Builder
    {
        return $query->whereHas('customer', function ($query) use ($name) {
            $query->orWhere('name', 'like', "%$name%");
        });
    }

    /**
     * Scope a query by transaction status.
     * @param  \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeTransactionStatus($query, $status): Builder
    {
        return $query->whereHas('transaction', function ($query) use ($status) {
            $query->where('status', $status);
        });
    }

    /**
     * Get the transaction.
     */
    public function transaction()
    {
        return $this->morphOne(Transaction::class, 'typeable');
    }

    /**
     * Check if the sales has transaction.
     *
     * @return bool
     */
    public function hasTransaction(): bool
    {
        return $this->transaction()->exists();
    }
}
