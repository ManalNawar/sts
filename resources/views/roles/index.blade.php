@extends('layouts.app')

@section('content')

<div class = 'container'>
<div class="card uper">
  <div class="card-header">
   All roles
  </div>
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
	<table class="table table-striped">
		<head>
			<th>Role</th>
			<th>Permissions</th>
			<th>Actions</th>
		</head>
		<tbody>
			@foreach($roles as $role)
			<tr>
				<td>{{$role->name}}</td>
				<td>
				@if(!empty($role->permissions))
					@foreach($role->permissions as $permission)
					<small class = 'label bg-orange'>{{$permission->name}}</small>
					@endforeach
				@endif
				</td>
				<td>
					<a href="{{url('/roles/edit')}}/{{$role->id}}" class = "btn btn-primary">edit</a>
					<a href="{{url('/roles/delete')}}/{{$role->id}}" class = "btn btn-danger">X</a>
				</td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div></div>
@endsection