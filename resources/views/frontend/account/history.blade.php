@extends('frontend.layouts.master')

@section('content')

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-brand" href="#">Account</div>

    <a href="{{ url("/account/".$account->id."/") }}" class="btn btn-default navbar-btn">Summary</a>
    <a href="{{ url("/account/".$account->id."/transaction") }}" class="btn btn-default navbar-btn">Transactions</a>
    <a href="{{ url("/account/".$account->id."/chart") }}" class="btn btn-default navbar-btn">Charts</a>
    <a href="{{ url("/account/".$account->id."/history") }}" class="btn btn-default navbar-btn active">History</a>
  </div>
</nav>


<!-- transactions panel -->
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-tasks"></i> My History
          <div class="btn-group pull-right">
            {!! Form::open(array('url' => '/account/'.$account->id.'/history', 'method' => 'POST')) !!}
            {!! Form::submit('Run History', array('class' => 'btn btn-danger btn-xs')) !!}
            {!! Form::close() !!}
          </div>
        </div>
				<div class="panel-body">

					<table class="table table-hover table-condensed">
						<thead>
							<tr>
								<th>Date</th>
								<th>Valorisation</th>
								<th>Performance €</th>
                <th>Performance %</th>
								<th>Cash</th>
								<th>Daily Variation</th>
								<th>Account Index</th>
							</tr>
						</thead>
						<tbody>
              @foreach ($account->historics as $hist)
								<tr>
									<td scope="row">{{ $hist->date }}</td>
									<td>{{ $hist->valorisation }}</td>
									<td>{{ $hist->performance }}</td>
									<td>{{ $hist->performancePct }}</td>
									<td>{{ $hist->cash }}</td>
									<td>{{ $hist->dailyVariation }}</td>
									<td>{{ $hist->indice }}</td>
								</tr>
							@endforeach

						</tbody>
					</table>

				</div>
			</div><!-- panel -->

		</div><!-- col-md-8 -->
	</div><!-- row -->


@endsection
