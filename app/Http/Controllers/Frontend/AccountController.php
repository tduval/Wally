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
use App\Http\Requests\Frontend\Account\CashRequest;

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
		$account = Accounts::findOrFail($id);
		$transactions = $account->transactions;
		return view('frontend.account.view', ['transactions' => $transactions, 'id' => $id, 'account' => $account]);
	}

	public function createAccount(AccountRequest $request)
	{
		$account = new Accounts;
		$account->user_id = auth()->user()->id;
    $account->name = $request->accountName;
		$account->type = $request->accountType;
		$account->broker = $request->accountBroker;
    $account->save();

		$transaction = new Transactions;
		$transaction->account_id = $account->id;
		$transaction->stock_id = '0';
		$transaction->type = 'Deposit';
		$transaction->price = $request->accountCash;
		$transaction->save();

		return redirect()->back()->withFlashSuccess("Account \"".$account->name."\" successfully created.");
	}

	public function deleteAccount($id)
	{
		$account = Accounts::findOrFail($id);
		$transactions = $account->transactions;
		foreach ($transactions as $transaction){
			$transaction->delete();
		}
		$account->delete();
		return redirect()->back()->withFlashSuccess("Account \"".$account->name."\" successfully deleted.");
	}

	public function addTransaction(TransactionRequest $request, $id)
	{
		$query = new YahooFinanceQuery;
		$requestStock = $request->input('transactionStock');
    $data = $query->symbolSuggest($requestStock)->get()[0];
		$stock = Stocks::firstOrNew(array('symbol' => $data['symbol']));
		$stock->name = $data['name'];
		$stock->type = $data['typeDisp'];
		$stock->exchange = $data['exchDisp'];
		$stock->save();

		$transaction = new Transactions;
		$transaction->account_id = $id;
		$transaction->stock_id = $stock->id;
		$transaction->type = $request->input('transactionType');
		$transaction->quantity = $request->input('transactionQuantity');
		$transaction->price = $request->input('transactionPrice');
		$transaction->save();
		return redirect()->back()->withFlashSuccess("Transaction added.");
	}

	public function deleteTransaction($id, $idtransaction)
	{
		$transaction = Transactions::findOrFail($idtransaction);
		$transaction->delete();
		return redirect()->back()->withFlashSuccess("Transaction removed.");
	}

	public function cash(CashRequest $request, $id)
	{
		$transaction = new Transactions;
		$transaction->account_id = $id;
		$transaction->stock_id = '0';
		$transaction->type = $request->input('cashType');
		$transaction->price = $request->input('cashPrice');
		$transaction->save();
		return redirect()->back()->withFlashSuccess("Cash flow updated.");
	}

}
