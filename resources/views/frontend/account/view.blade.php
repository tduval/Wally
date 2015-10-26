@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-3">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> Add a Transaction</div>
				<div class="panel-body">
					{!! Form::open(array('url' => '/account/'.$account->id, 'method' => 'POST')) !!}

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
					{!! Form::open(array('url' => '/account/'.$account->id.'/cash', 'method' => 'POST')) !!}
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

		<div class="col-md-8">

			<div class="panel panel-primary">
				<div class="panel-heading"><i class="fa fa-home"></i> My Account summary</div>
				<div class="panel-body">
					Cash : {{ $account->getCashAmount() }}
					Total Investment : {{ $account->getInvestAmountForAllStock() }}
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-tasks"></i> My Stock Quote</div>
				<div class="panel-body">
					<table class="table table-hover">
						<thead>
							<tr>
								<th>Symbol</th>
								<th>Name</th>
								<th>Exchange</th>
								<th>Investment</th>
								<th>Current Price</th>
								<th>Valorisation</th>
								<th>Change %</th>
								<th>Performance €</th>
								<th>Performance %</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($account->getStocksCollection() as $st)
							{{--*/ $quote = $st->getCurrentQuote() /*--}}
								<tr>
									<td scope="row">{{ $st->symbol }}</td>
									<td>{{ $st->name }}</td>
									<td>{{ $st->exchange }}</td>
									<td>{{ $account->getInvestAmountForSpecificStock($st->id) }}</td>
									<td>{{ $quote['LastTradePriceOnly'] }}</td>
									<td>{{ $account->getTotalQuantityForSpecificStock($st->id)*$quote['LastTradePriceOnly'] }}</td>
									<td>{{ $quote['ChangeinPercent'] }}</td>
									<td>{{ ($account->getTotalQuantityForSpecificStock($st->id)*$quote['LastTradePriceOnly']) - ($account->getInvestAmountForSpecificStock($st->id)) }}</td>
									<td>{{ round(((($account->getTotalQuantityForSpecificStock($st->id)*$quote['LastTradePriceOnly'])-($account->getInvestAmountForSpecificStock($st->id)))/($account->getInvestAmountForSpecificStock($st->id))*100), 2) }}%</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div><!-- panel -->

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-tasks"></i> My Transactions</div>

				<div class="panel-body">

					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Date</th>
								<th>Stock Name</th>
								<th>Type</th>
								<th>Quantity</th>
								<th>Price</th>
								<th>Commission</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($account->transactions as $transaction)
								<tr>
									<td scope="row">{{ $transaction->created_at }}</td>
									<td>{{ $transaction->stock->name }}</td>
									<td>{{ $transaction->type }}</td>
									<td>{{ $transaction->quantity }}</td>
									<td>{{ $transaction->price }}</td>
									<td>{{ $transaction->commission }}</td>
									<td><a href="{{ url("/account/".$account->id."/transaction/".$transaction->id."/delete") }}" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div><!-- panel -->

		</div><!-- col-md-8 -->

	</div><!-- row -->


@endsection
