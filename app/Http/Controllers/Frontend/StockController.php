<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\YahooFinanceQuery;

/**
 * Class StockController
 * @package App\Http\Controllers\Frontend
 */
class StockController extends Controller {

	/**
	 * @return mixed
	 */
	public function index()
	{
		return view('frontend.stock')
			->withUser(auth()->user());
	}

	public function postSearch(Request $request)
	{
		$requestStock = $request->input('stockSearch');
    $query = new YahooFinanceQuery;
    $data = $query->symbolSuggest($requestStock)->get();
    return view('frontend.stock', ['stocks' => $data]);
	}
}
