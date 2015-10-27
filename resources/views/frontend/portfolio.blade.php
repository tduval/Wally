@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-4 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-search"></i> New Account</div>

				<div class="panel-body">
					{!! Form::open(array('url' => '/account', 'method' => 'POST')) !!}
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Name</span>
							{!! Form::text('accountName', null, array('class' => 'form-control', 'placeholder' => "Type an account name here")) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Type</span>
							{!! Form::select('accountType', ['Comptes Titres' => 'Comptes Titres', 'PEA' => 'PEA', 'PEA-PME' => 'PEA-PME'], null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Broker</span>
							{!! Form::select('accountBroker', ['Boursorama' => 'Boursorama', 'Bourse Direct' => 'Bourse Direct', 'Binck' => 'Binck', 'Fortuneo' => 'Fortuneo'], null, ['class' => 'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="input-group">
							<span class="input-group-addon" style="min-width:75px;">Price</span>
							{!! Form::text('accountCash', null, array('class' => 'form-control', 'placeholder' => "Amount of cash")) !!}
							<span class="input-group-addon">€</span>
						</div>
					</div>
					<div class="form-group">
						<span class="input-group-btn">
							{!! Form::submit('Create', array('class' => 'btn btn-default btn-primary')) !!}
						</span>
					</div><!-- /input-group -->
					{!! Form::close() !!}
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
										<td><a href="{{ url("/account/$account->id") }}" class="btn btn-xs btn-primary"><i class="fa fa-eye"></i></a>
												<a href="{{ url("/account/$account->id/delete") }}" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i></a></td>
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
