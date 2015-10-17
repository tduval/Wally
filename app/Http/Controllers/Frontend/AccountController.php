<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Accounts;
/**
 * Class AccountController
 * @package App\Http\Controllers\Frontend
 */
class AccountController extends Controller {

	/**
	 * @return mixed
	 */
	public function index()
	{
		return view('frontend.account.view');
	}

	public function createAccount(Request $request)
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

	public function deleteAccount(Request $request)
	{
		$account = Accounts::find($request->id);
		$account->delete();
		return redirect('portfolio');
	}

	public function addTransaction(Request $request)
	{
		// $account = new Accounts;
		// $account->user_id = auth()->user()->id;
    // $account->name = $request->accountName;
		// $account->type = $request->accountType;
		// $account->broker = $request->accountBroker;
    //     $account->save();
		//
		// $accounts = Accounts::where('user_id', auth()->user()->id)->get();
		//return redirect()->back();
	}

}
