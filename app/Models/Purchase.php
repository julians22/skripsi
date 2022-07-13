<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['status_label', 'grand_total'];

    /**
     * Get the status label of the Sales
     */
    public function getStatusLabelAttribute(){
        return $this->transaction->status;
    }

    /**
     * Get the supplier that owns the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id');
    }

    /**
     * Get the user associated with the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Get the purchase details associated with the Purchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details(): HasMany
    {
        return $this->hasMany(PurchaseDetail::class, 'purchases_id', 'id');
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

    public function scopeSupplierName($query, string $name): Builder
    {
        return $query->whereHas('supplier', function ($query) use ($name) {
            $query->orWhere('name', 'like', "%{$name}%");
        });
    }

    //get grand total
    public function getGrandTotalAttribute()
    {
        return clear_number($this->total);
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
