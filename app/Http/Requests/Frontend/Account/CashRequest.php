<?php namespace App\Http\Requests\Frontend\Account;

use App\Http\Requests\Request;

/**
 * Class CashRequest
 * @package App\Http\Requests\Frontend\Account
 */
class CashRequest extends Request {

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
			'cashType'  => 'required',
			'cashPrice' => 'required|numeric'
		];
	}
}
