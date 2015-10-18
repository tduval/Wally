<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Accounts;
use App\YahooFinanceQuery;
use App\Transactions;
use App\Stocks;
use App\Http\Requests\Frontend\Account\TransactionRequest;
use App\Http\Requests\Frontend\Account\AccountRequest;

/**
 * Class AccountController
 * @package App\Http\Controllers\Frontend
 */
class AccountController extends Controller {

	/**
	 * @return mixed
	 */
	public function index($id)
	{
		$transactions = Transactions::where('account_id', $id)->get();
		$stocks = Stocks::all();
		return view('frontend.account.view', ['transactions' => $transactions, 'id' => $id, 'stocks' => $stocks]);
	}

	public function createAccount(AccountRequest $request)
	{
		$account = new Accounts;
		$account->user_id = auth()->user()->id;
    $account->name = $request->accountName;
		$account->type = $request->accountType;
		$account->broker = $request->accountBroker;
    $account->save();

		$accounts = Accounts::where('user_id', auth()->user()->id)->get();
		return redirect('portfolio');
	}

	public function deleteAccount($id)
	{
		$account = Accounts::find($id);
		$account->delete();
		return redirect('portfolio');
	}

	public function addTransaction(TransactionRequest $request, $id)
	{
		$query = new YahooFinanceQuery;
		$requestStock = $request->input('TransactionStock');
    $data = $query->symbolSuggest($requestStock)->get()[0];
		debug($data);
		$stock = Stocks::firstOrNew(array('symbol' => $data['symbol']));
		$stock->name = $data['name'];
		$stock->type = $data['typeDisp'];
		$stock->exchange = $data['exchDisp'];
		$stock->save();

		$transaction = new Transactions;
		$transaction->account_id = $id;
		$transaction->stock_id = $stock->id;
		$transaction->type = $request->transactionType;
		$transaction->quantity = $request->transactionQuantity;
		$transaction->price = $request->transactionPrice;
		$transaction->save();
		return back();
	}

}
