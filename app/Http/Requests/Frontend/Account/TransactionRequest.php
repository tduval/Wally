<?php namespace App\Http\Requests\Frontend\Account;

use App\Http\Requests\Request;

/**
 * Class TransactionRequest
 * @package App\Http\Requests\Frontend\Account
 */
class TransactionRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'transactionStock' 	=> 'required',
			'transactionType'  => 'required',
			'transactionQuantity' => 'required|integer',
			'transactionPrice' => 'required|numeric'
		];
	}
}
