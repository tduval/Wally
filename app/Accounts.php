<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accounts extends Model
{

    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'accounts';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function user() {
  		return $this->belongsTo('App\Models\Access\User');
  	}

    public function transactions() {
  		return $this->hasMany('App\Transactions', 'account_id');
  	}

    public function getCashAmount() {
      $transactions = $this->transactions;
      $amount = 0;
      foreach ($transactions as $t) {
        if ($t['type'] == 'Deposit'){
          $amount += $t['price'];
        }elseif ($t['type'] == 'Withdrawal'){
          $amount -= $t['price'];
        }
      }
      return $amount;
    }

}
