@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-3 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> Add a Transaction</div>
				<div class="panel-body">
					<form action="{{ url('/account/'.$id) }}" method="post">
					<div class="form-group">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="input-group">
							<span class="input-group-addon">Stock</span>
							<input type="text" name="TransactionStock" class="form-control" placeholder="Type a stock security here">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Type</span>
							<!--<input type="text" name="accountType" class="form-control" placeholder="Type an account type here">-->
							<select class="form-control" name="transactionType">
								<option>Buy</option>
								<option>Sell</option>
								<option>Deposit</option>
								<option>Withdrawal</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Quantity</span>
							<input type="number" name="transactionQuantity" class="form-control" placeholder="Number of shares">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Price</span>
							<input type="text" name="transactionPrice" class="form-control" placeholder="Amount of price">
							<span class="input-group-addon">$</span>
						</div>
					</div>
					<div class="form-group">
						<span class="input-group-btn">
							<button class="btn btn-default btn-primary" type="submit">Add!</button>
						</span>
					</div><!-- /input-group -->
					</form>
				</div>
			</div><!-- panel -->

		</div><!-- col-md-10 -->

		<div class="col-md-7">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-home"></i> My Transactions</div>

				<div class="panel-body">

					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Stock Name</th>
								<th>Type</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Commission</th>
								<th>Date</th>
							</tr>
						</thead>
						<tbody>
							@if (isset($transactions))
								@foreach ($transactions as $transaction)
									<tr>
										<th scope="row">{{ $transaction['id'] }}</th>
										@foreach ($stocks as $stock)
											@if ($stock['id'] == $transaction['stock_id'])
												<td>{{ $stock['name'] }}</td>
											@endif
										@endforeach
										<td>{{ $transaction['type'] }}</td>
										<td>{{ $transaction['quantity'] }}</td>
										<td>{{ $transaction['price'] }}</td>
										<td>{{ $transaction['commission'] }}</td>
										<td>{{ $transaction['created_at'] }}</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>

				</div>
			</div><!-- panel -->

		</div><!-- col-md-10 -->

	</div><!-- row -->

@endsection
