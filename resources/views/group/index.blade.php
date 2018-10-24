@extends('layouts.app')

@section('content')
<style>
  .uper {
    margin-top: 40px;
  }
</style>
<div class = 'container'>
<div class="uper">
  @if(session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div><br />
  @endif
  <table class="table table-striped">
    <thead>
        <tr>
          <td>ID</td>
          <td>group name</td>
          <td>group description</td>
          <td>Action</td>
        </tr>
    </thead>
    <tbody>
        @foreach($groups as $group)
        <tr>
            <td>{{$group->id}}</td>
            <td>{{$group->group_name}}</td>
            <td>{{$group->group_description}}</td>
            <td><a href="{{ route('group.edit',$group->id)}}" class="btn btn-primary">Edit</a></td>
            <td>
                {{-- <form action="{{ route('shares.destroy', $group->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit">Delete</button>
                </form> --}}
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
<div><div>
@endsection