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

    public function stocks(){
      return $this->belongsToMany('App\Stocks', 'transactions', 'account_id', 'stock_id');
    }

    public function getAllTransactionsForSpecificStock($stockid) {
  		return $this->transactions()->where('stock_id', '=', $stockid)->get();
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

    public function getStockIDList(){
      return $this->transactions()->where('stock_id', '!=', '0')->get()->unique('stock_id')->pluck('stock_id');
    }

    public function getStocksCollection(){
      return Stocks::findOrFail($this->getStockIDList()->toArray());
    }

    public function getInvestAmountForSpecificStock($stockid){
      $amount = 0;
      $transactions = $this->transactions->where('stock_id', $stockid);
      foreach ($transactions as $t) {
        if ($t['type'] == "Buy"){
          $amount += $t['price']*$t['quantity'];
        }elseif ($t['type'] == 'Sell') {
          $amount -= $t['price']*$t['quantity'];
        }
      }
      return $amount;
    }

    public function getTotalQuantityForSpecificStock($stockid){
      $quantity = 0;
      $transactions = $this->transactions->where('stock_id', $stockid);
      foreach ($transactions as $t) {
        if ($t['type'] == "Buy"){
          $quantity += $t['quantity'];
        }elseif ($t['type'] == 'Sell') {
          $quantity -= $t['quantity'];
        }
      }
      return $quantity;
    }

    public function getPRUForSpecificStock($stockid){
      return $this->getInvestAmountForSpecificStock($stockid)/$this->getTotalQuantityForSpecificStock($stockid);
    }

    public function getInvestAmountForAllStock(){
      $amount = 0;
      $stocks = $this->getStockIDList();
      foreach ($stocks as $s) {
        $amount += $this->getInvestAmountForSpecificStock($s);
      }
      return $amount;
    }

}
