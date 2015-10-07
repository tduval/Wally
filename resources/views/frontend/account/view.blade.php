@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-4 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> Add a Transaction</div>

				<div class="panel-body">
					<form action="{{ url("/account/add") }}" method="post">
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
						<div class="input-group spinner">
							<span class="input-group-addon">Quantity</span>
							<input type="text" name="transactionPrice" class="form-control" placeholder="Amount of price">
							<div class="input-group-btn-vertical">
					      <button class="btn btn-default" type="button"><i class="fa fa-caret-up"></i></button>
					      <button class="btn btn-default" type="button"><i class="fa fa-caret-down"></i></button>
					    </div>
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

		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-home"></i> My Account</div>

				<div class="panel-body">

					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Type</th>
								<th>Broker</th>
								<th>Detail</th>
							</tr>
						</thead>
						<tbody>
							@if (isset($accounts))
								@foreach ($accounts as $account)
									<tr>
										<th scope="row">{{ $account['id'] }}</th>
										<td>{{ $account['name'] }}</td>
										<td>{{ $account['type'] }}</td>
										<td>{{ $account['broker'] }}</td>
										<td><a href="{{ url("/account/$account->id/view") }}" class="fa fa-eye"></td>
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
