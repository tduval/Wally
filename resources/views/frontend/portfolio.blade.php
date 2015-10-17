@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-4 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> New Account</div>

				<div class="panel-body">
					<form action="{{ url('/account') }}" method="post">
					<div class="form-group">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="input-group">
							<span class="input-group-addon">Name</span>
							<input type="text" name="accountName" class="form-control" placeholder="Type an account name here">
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Type</span>
							<!--<input type="text" name="accountType" class="form-control" placeholder="Type an account type here">-->
							<select class="form-control" name="accountType">
								<option>Comptes Titres</option>
								<option>PEA</option>
								<option>PEA-PME</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon">Broker</span>
							<!--<input type="text" name="accountBroker" class="form-control" placeholder="Type the Broker of your account here">-->
							<select class="form-control" name="accountBroker">
								<option>Boursorama</option>
								<option>Bourse Direct</option>
								<option>Binck</option>
								<option>Fortuneo</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<span class="input-group-btn">
							<button class="btn btn-default btn-primary" type="submit">Create!</button>
						</span>
					</div><!-- /input-group -->
					</form>
				</div>
			</div><!-- panel -->

		</div><!-- col-md-10 -->

		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-home"></i> My Accounts</div>

				<div class="panel-body">

					<table class="table table-hover">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Type</th>
								<th>Broker</th>
								<th>Actions</th>
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
										<td><a href="{{ url("/account/$account->id") }}" class="fa fa-eye">
												<a href="{{ url("/account/$account->id/delete") }}" class="fa fa-trash-o"></td>
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
