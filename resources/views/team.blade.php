@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row mt-3">
        <div class="col-6 m-auto">
            <div class="card">
              <div class="card-header">
                 Add Team Member
              </div>
                <div class="card-body">
                    {{-- @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </div>
                    @endif --}}
                  @if (session('success_message'))
                    <div class="alert alert-success">
                        {{session('success_message')}}
                    </div>
                  @endif

                        <form action="{{url('team/insert')}}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="" class="form-label">Team Member Name</label>
                                <input @if(old('name')) readonly @endif type="text" class="@if(old('name')) is-valid @endif form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                                    @error('name')
                                     <small class="text-danger">{{ $message }}</small>
                                    @enderror
                            </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Team Member Phone Number</label>
                            <input @if(old('phone_number')) readonly @endif type="text" class="@if(old('phone_number')) is-valid @endif form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}">
                            @error('phone_number')
                            <small class="text-danger">{{ $message }}</small>
                           @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </form>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                   Team Member List
                   <span class="badge bg-success">Total : {{$teams_count}}</span>
                   <span class="badge bg-success bg-gradient">This page Total : {{$teams->count()}}</span>

                        <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Trash
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <table class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Action</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($deleted_teams as $deleted_team)
                                        <tr>
                                          <td>{{ $deleted_team->name }}</td>
                                          <td>{{ $deleted_team->phone_number }}</td>
                                          <td>
                                            <a href="{{ url('team/restore') }}/{{ $deleted_team->id }}" class="btn btn-danger btn-sm">Restore</a>
                                          </td>
                                        </tr>
                                      @endforeach
                                    </tbody>
                                  </table>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                  <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($teams as $team)
                                {{-- <tr class="
                                @if ($loop->odd)
                                    table-info
                                        @else
                                        table-danger
                                        @endif"> --}}
                                     <td>{{ $teams->firstitem() + $loop->index }}</td>
                                    {{-- <td>{{$loop->index + 1}}</td> --}}
                                    <td>{{$team->name}}</td>
                                    <td>{{$team->phone_number}}</td>
                                    <td>{{$team->created_at->diffForHumans()}}</td>
                                    <td>
                                        <a href="{{url('team/delete')}}/{{$team->id}}" class="btn btn-danger btn-sm">Delete</a>
                                        <a href="{{url('team/edit')}}/{{$team->id}}"  class="btn btn-primary btn-sm">Edit in new page</a>
                                        {{-- <a href="{{url('team/edit')}}/{{$team->id}}"  class="btn btn-primary bg-gradient btn-sm">Edit</a> --}}
                                        <button type="button" class="btn btn-primary btn-sm px-4 mt-2" data-bs-toggle="modal" data-bs-target="#edit_button{{$team->id}}">
                                           Edit
                                          </button>
                                        <!-- Modal -->
                                                <div class="modal fade" id="edit_button{{$team->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{url('team/edit/post')}}/{{ $team->id }}" method="POST">
                                                                    @csrf
                                                                    <div class="mb-3">
                                                                        <label for="" class="form-label">Team Member Name</label>
                                                                        <input type="text" class="form-control" name="name" value="{{ $team->name }}">
                                                                    </div>
                                                                        <div class="mb-3">
                                                                            <label for="" class="form-label">Team Member Phone Number</label>
                                                                            <input type="text" class="form-control" name="phone_number" value="{{ $team->phone_number }}">
                                                                        </div>
                                                                <button type="submit" class="btn btn-primary bg-gradient">Edit</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if ($teams->count() == 0)
                            <tr class="text-center text-danger">
                                <td colspan="50">No Data to Show</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <a href="{{url('team/delete')}}/all" class="btn btn-warning btn-sm">Delete All</a>
                    <div class="row mt-3">
                        <div class="col-12">
                            <ul class="pagination justify-content-center">
                              {{ $teams->links() }}
                            </ul>
                            </div>
                    </div>

              </div>
        </div>
        </div>
    </div>
</div>
@endsection

@section('footer_content')
   Team Page
@endsection



