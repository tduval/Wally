<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Account;
/**
 * Class AccountController
 * @package App\Http\Controllers\Frontend
 */
class PortfolioController extends Controller {

	/**
	 * @return mixed
	 */
	public function index()
	{
		$accounts = Account::where('user_id', auth()->user()->id)->get();
		return view('frontend.portfolio', ['accounts' => $accounts]);
	}

}
