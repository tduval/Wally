<?php

namespace App;

use Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\YahooFinanceQuery;

class Account extends Model
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
  		return $this->hasMany('App\Transaction', 'account_id');
  	}

    public function historics() {
  		return $this->hasMany('App\Historic', 'account_id');
  	}

    public function stocks(){
      return $this->belongsToMany('App\Stock', 'transactions', 'account_id', 'stock_id');
    }

    public function getAllTransactionsForSpecificStock($stockid) {
  		return $this->transactions()->where('stock_id', '=', $stockid)->get();
  	}

    public function getCashAmount() {
      return $this->cash;
    }

    public function setCashAmount($type, $amount) {
      if (($type == 'Deposit') || ($type == 'Sell')){
        $this->cash += $amount;
      }elseif (($type == 'Withdrawal') || ($type == 'Buy')){
        $this->cash -= $amount;
      }
      $this->save();
    }

    public function getStockIDList(){
      return $this->transactions()->where('stock_id', '!=', '0')->get()->unique('stock_id')->pluck('stock_id');
    }

    public function getStocksCollection(){
      return Stock::findOrFail($this->getStockIDList()->toArray());
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

    public function runHistory(){
      $historic = new Historic;
      $historic->account_id = $this->id;
      $historic->date = date("Y-m-d");
      $historic->investment = $this->getInvestAmountForAllStock();

      $query = new YahooFinanceQuery;
      $valorisationStock = 0;
      $stocks = $this->getStocksCollection()->pluck('symbol');
      $result = $query->quote(array($stocks), array('l1'))->get();
      foreach($result as $stock){
        $valorisationStock += $stock['LastTradePriceOnly']*$this->getTotalQuantityForSpecificStock(Stock::where('symbol', $stock['Symbol'])->first()->id);
      }

      $historic->valorisation = $valorisationStock;
      $historic->performance = $historic->valorisation-$historic->investment;
      $historic->performancePct = ($historic->performance/$historic->investment)*100;
      $historic->cash = $this->getCashAmount();
      $historic->indice = ($historic->valorisation/$historic->investment)*100;
      $historic->save();

    }

}
