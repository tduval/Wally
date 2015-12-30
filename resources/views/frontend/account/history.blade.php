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
				<div class="panel-heading"><i class="fa fa-tasks"></i> My History</div>
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
								<th>Account Parts</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>

				</div>
			</div><!-- panel -->

		</div><!-- col-md-8 -->
	</div><!-- row -->


@endsection
