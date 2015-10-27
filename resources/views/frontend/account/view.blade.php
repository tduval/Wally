@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-8">

			<div class="panel panel-primary">
				<div class="panel-heading"><i class="fa fa-home"></i> My Account summary</div>
				<div class="panel-body">
					Cash : {{ $account->getCashAmount() }}
					Total Investment : {{ $account->getInvestAmountForAllStock() }}
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-tasks"></i> My Stock Quote
					<div class="btn-group pull-right">
						<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalAddTransaction">Add Transaction</button>
						<button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAddCash">Add Cash</button>
					</div>
				</div>

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

	<!-- Modal AddTransaction -->
	<div class="modal fade" id="modalAddTransaction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i> Add a new Transaction</h4>
	      </div>
				{!! Form::open(array('url' => '/account/'.$account->id, 'method' => 'POST')) !!}
	      <div class="modal-body">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Stock</span>
							{!! Form::text('transactionStock', null, array('class' => 'form-control', 'placeholder' => "Type a stock security here")) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Type</span>
							{!! Form::select('transactionType', ['Buy' => 'Buy', 'Sell' => 'Sell'], null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Quantity</span>
							{!! Form::text('transactionQuantity', null, array('class' => 'form-control', 'placeholder' => "Number of Shares")) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Price</span>
							{!! Form::text('transactionPrice', null, array('class' => 'form-control', 'placeholder' => "Amount of price")) !!}
							<span class="input-group-addon">€</span>
						</div>
					</div>

	      </div>
	      <div class="modal-footer">
					<div class="form-group">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							{!! Form::submit('Add', array('class' => 'btn btn-default btn-primary')) !!}
						</span>
					</div><!-- /input-group -->
	      </div>
				{!! Form::close() !!}
	    </div>
	  </div>
	</div><!-- end of Modal -->

	<!-- Modal AddCash -->
	<div class="modal fade" id="modalAddCash" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i> Manage Liquidity</h4>
	      </div>
				{!! Form::open(array('url' => '/account/'.$account->id.'/cash', 'method' => 'POST')) !!}
	      <div class="modal-body">

					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Type</span>
							{!! Form::select('cashType', ['Deposit' => 'Deposit', 'Withdrawal' => 'Withdrawal'], null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Price</span>
							{!! Form::text('cashPrice', null, array('class' => 'form-control', 'placeholder' => "Amount of price")) !!}
							<span class="input-group-addon">€</span>
						</div>
					</div>

	      </div>
	      <div class="modal-footer">
					<div class="form-group">
						<span class="input-group-btn">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							{!! Form::submit('Create', array('class' => 'btn btn-default btn-primary')) !!}
						</span>
					</div><!-- /input-group -->
	      </div>
				{!! Form::close() !!}
	    </div>
	  </div>
	</div><!-- end of Modal -->

@endsection
