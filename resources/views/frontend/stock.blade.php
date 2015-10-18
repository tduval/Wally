@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-4 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> Searching Stock</div>

				<div class="panel-body">
					{!! Form::open(array('url' => '/stock', 'method' => 'POST')) !!}
					<div class="input-group">
						{!! Form::text('stockSearch', null, array('class' => 'form-control', 'placeholder' => "Type a stock security here")) !!}
						<span class="input-group-btn">
							{!! Form::submit('Search', array('class' => 'btn btn-default')) !!}
						</span>
					</div><!-- /input-group -->
					{!! Form::close() !!}
				</div>
			</div><!-- panel -->

		</div><!-- col-md-10 -->

		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-home"></i> Stock Result</div>

				<div class="panel-body">

					<table class="table table-hover">
						<thead>
							<tr>
								<th>Symbol</th>
								<th>Name</th>
								<th>Exchange</th>
								<th>Type</th>
								<th>Detail</th>
							</tr>
						</thead>
						<tbody>
							@if (isset($stocks))
								@foreach ($stocks as $stock)
									<tr>
										<th scope="row">{{ $stock['symbol'] }}</th>
										<td>{{ $stock['name'] }}</td>
										<td>{{ $stock['exchDisp'] }}</td>
										<td>{{ $stock['typeDisp'] }}</td>
										<td><a href="{{ url('/stock/') }}" class="fa fa-eye"></td>
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
