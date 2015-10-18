@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-3 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> Add a Transaction</div>
				<div class="panel-body">
					{!! Form::open(array('url' => '/account/'.$id, 'method' => 'POST')) !!}

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Stock</span>
							{!! Form::text('transactionStock', null, array('class' => 'form-control', 'placeholder' => "Type a stock security here")) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Type</span>
							{!! Form::select('transactionType', ['Buy' => 'Buy', 'Sell' => 'Sell'], null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Quantity</span>
							{!! Form::text('transactionQuantity', null, array('class' => 'form-control', 'placeholder' => "Number of Shares")) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Price</span>
							{!! Form::text('transactionPrice', null, array('class' => 'form-control', 'placeholder' => "Amount of price")) !!}
							<span class="input-group-addon">€</span>
						</div>
					</div>
					<div class="form-group">
						<span class="input-group-btn">
							{!! Form::submit('Add', array('class' => 'btn btn-default btn-primary')) !!}
						</span>
					</div><!-- /input-group -->
					{!! Form::close() !!}
				</div>
			</div><!-- panel -->

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> Add Account Cash</div>
				<div class="panel-body">
					{!! Form::open(array('url' => '/account/'.$id.'/cash', 'method' => 'POST')) !!}
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Type</span>
							{!! Form::select('cashType', ['Deposit' => 'Deposit', 'Withdrawal' => 'Withdrawal'], null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Price</span>
							{!! Form::text('cashPrice', null, array('class' => 'form-control', 'placeholder' => "Amount of price")) !!}
							<span class="input-group-addon">€</span>
						</div>
					</div>
					<div class="form-group">
						<span class="input-group-btn">
							{!! Form::submit('Add', array('class' => 'btn btn-default btn-success')) !!}
						</span>
					</div><!-- /input-group -->
					{!! Form::close() !!}
				</div>
			</div><!-- panel -->

		</div><!-- col-md-3 -->

		<div class="col-md-7">

			<div class="panel panel-primary">
				<div class="panel-heading"><i class="fa fa-home"></i> My Account summary</div>
				<div class="panel-body">
					Cash : {{ $transactions[0]->account->getCashAmount() }}
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-tasks"></i> My Transactions</div>

				<div class="panel-body">

					<table class="table table-hover">
						<thead>
							<tr>
								<th>Date</th>
								<th>Stock Name</th>
								<th>Type</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Commission</th>
							</tr>
						</thead>
						<tbody>
							@if (isset($transactions))
								@foreach ($transactions as $transaction)
									<tr>
										<td scope="row">{{ $transaction['created_at'] }}</td>
										@foreach ($stocks as $stock)
											@if ($stock['id'] == $transaction['stock_id'])
												<th>{{ $stock['name'] }}</th>
											@endif
										@endforeach
										<td>{{ $transaction['type'] }}</td>
										<td>{{ $transaction['quantity'] }}</td>
										<td>{{ $transaction['price'] }}</td>
										<td>{{ $transaction['commission'] }}</td>
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
