<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    public function account() {
  		return $this->belongsTo('App\Accounts');
  	}

    public function stock() {
  		return $this->hasOne('App\Stocks');
  	}

}
