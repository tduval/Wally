<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\YahooFinanceQuery;

class Stock extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stocks';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'type', 'exchange', 'symbol'];

    public function transactions(){
      return $this->hasMany('App\Transaction', 'stock_id');
    }

    public function accounts(){
      return $this->belongsToMany('App\Account', 'transactions', 'stock_id', 'account_id');
    }

    public function getCurrentQuote(){
      $query = new YahooFinanceQuery;
      $quoteParams = array(
      	'c' => 'Change_PercentChange',
      	'c1' => 'Change',
        'p2' => 'ChangeinPercent',
      	'c3' => 'Commission',
      	'd' => 'DividendShare',
      	'd1' => 'LastTradeDate',
      	't1' => 'LastTradeTime',
      	'i' => 'MoreInfo',
      	'j1' => 'MarketCapitalization',
      	'l1' => 'LastTradePriceOnly',
      	'n' => 'Name',
      	'r' => 'PERatio',
      	'r1' => 'DividendPayDate',
      	's' => 'Symbol',
      	'v' => 'Volume',
      	'x' => 'StockExchange',
      	'y' => 'DividendYield',
      );
      $result = $query->quote(array($this->symbol), $quoteParams)->get();
      return $result[0];
    }

}
