@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-6">

			<div class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-home"></i> My Accounts<button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#modalCreateAccount">Create a new Account</button></div>

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

	<!-- Modal CreateAccount -->
	<div class="modal fade" id="modalCreateAccount" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-plus-circle"></i> Create a new Account</h4>
	      </div>
				{!! Form::open(array('url' => '/account', 'method' => 'POST')) !!}
	      <div class="modal-body">

					<div class="form-group"><!-- Modal Body filled with Creation Form Account -->
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
					</div><!-- end of Modal Body -->

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
