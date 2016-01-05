<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Account;
use App\YahooFinanceQuery;
use App\Transaction;
use App\Stock;
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
		$account = Account::findOrFail($id);
		return view('frontend.account.view', ['account' => $account]);
	}

	public function transactionView($id)
	{
		$account = Account::findOrFail($id);
		return view('frontend.account.transaction', ['account' => $account]);
	}

	public function ChartView($id)
	{
		$account = Account::findOrFail($id);
		return view('frontend.account.chart', ['account' => $account]);
	}

	public function historyView($id)
	{
		$account = Account::findOrFail($id);
		return view('frontend.account.history', ['account' => $account]);
	}

	public function runHistory($id)
	{
		$account = Account::findOrFail($id);
		$account->runHistory();
		return view('frontend.account.history', ['account' => $account]);
	}

	public function getHistory($id)
	{
		$account = Account::findOrFail($id);
		return response()->json([$account->historics]);
	}

	public function createAccount(AccountRequest $request)
	{
		$account = new Account;
		$account->user_id = auth()->user()->id;
    $account->name = $request->accountName;
		$account->type = $request->accountType;
		$account->broker = $request->accountBroker;
    $account->save();

		$transaction = new Transaction;
		$transaction->account_id = $account->id;
		$transaction->stock_id = '0';
		$transaction->type = 'Deposit';
		$transaction->price = $request->accountCash;
		$transaction->save();

		return redirect()->back()->withFlashSuccess("Account \"".$account->name."\" successfully created.");
	}

	public function deleteAccount($id)
	{
		$account = Account::findOrFail($id);
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
		$stock = Stock::firstOrNew(array('symbol' => $data['symbol']));
		$stock->name = $data['name'];
		$stock->type = $data['typeDisp'];
		$stock->exchange = $data['exchDisp'];
		$stock->save();

		$transaction = new Transaction;
		$transaction->account_id = $id;
		$transaction->stock_id = $stock->id;
		$transaction->type = $request->input('transactionType');
		$transaction->quantity = $request->input('transactionQuantity');
		$transaction->price = $request->input('transactionPrice');
		$transaction->save();
		if ($request->input('transactionDeductCash') == true){
			Account::findOrFail($id)->setCashAmount($request->input('transactionType'), $request->input('transactionQuantity')*$request->input('transactionPrice'));
		}
		return redirect()->back()->withFlashSuccess("Transaction added.");
	}

	public function deleteTransaction($id, $idtransaction)
	{
		$transaction = Transaction::findOrFail($idtransaction);
		$transaction->delete();
		return redirect()->back()->withFlashSuccess("Transaction removed.");
	}

	public function cash(CashRequest $request, $id)
	{
		$transaction = new Transaction;
		$transaction->account_id = $id;
		$transaction->stock_id = '0';
		$transaction->type = $request->input('cashType');
		$transaction->price = $request->input('cashPrice');
		$transaction->save();
		Account::findOrFail($id)->setCashAmount($request->input('cashType'), $request->input('cashPrice'));
		return redirect()->back()->withFlashSuccess("Cash flow updated.");
	}

}
