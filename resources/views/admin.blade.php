@extends('layouts.app')

@section('title', 'Admin')
@section('content')
<style>
.tableoverflow-y {
    position: relative;
    height: calc(100vh - 600px);
    top: 10px;
    margin: 0 20px 30px 0;
    overflow-y: scroll;
}
</style>
<div class="container">
    <div class="row justify-content-center">
        <!-- Profile Section -->
        <div class="col-md-3">
            <div class="card p-3">
                <h4>Profile</h4>
                <p>
                    <span class="fw-bold">{{ Auth::user()->name }}</span>
                    <br>
                    <small>{{ Auth::user()->email }}</small>
                </p>
                <a href="{{ route('profile', Auth::user()->id) }}" class="btn btn-primary btn-sm">My Profile</a>
                <a href="{{ route('admin') }}" class="btn btn-dark btn-sm mt-2">Admin Dashboard</a>
                <hr>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-light btn-sm">← Logout</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card p-3">
                <h1 class="fw-bold">Admin Dashboard</h1>
                <div class="row mt-4">
                    <!-- Total users -->
                    <div class="col">
                        <div class="card p-2">
                            <p>Total Users</p>
                            <h2 class="fw-bold">
                                {{ count($users) }}
                            </h2>
                        </div>
                    </div>
                    <!-- Total Twats -->
                    <div class="col">
                        <div class="card p-2">
                            <p>Total Twats</p>
                            <h2 class="fw-bold">
                                {{ $totaltwats }}
                            </h2>
                        </div>
                    </div>
                    <!-- Total Twats -->
                    <div class="col">
                        <div class="card p-2">
                            <p>Total Replies</p>
                            <h2 class="fw-bold">
                                {{ $totalreplies }}
                            </h2>
                        </div>
                    </div>
                    <hr class="my-3">
                    <h1 class="fw-bold">User Management
                        <a href="{{ route('generate-pdf') }}" target="_blank" class="btn btn-light btn-sm float-end">⬇ Download PDF</a>
                    </h1>
                    @if(session('success'))
                    <div class="alert alert-primary" role="alert">
                        {{session('success')}}
                    </div>
                    @endif
                    <div class="tableoverflow-y">
                        <table class="table mt-3 border" id="usermanagement">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->id }} </td>
                                <td>{{ $user->name }}
                                    @if($user->type == 'admin')
                                    <span class="badge rounded-pill text-bg-warning">Admin</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-dark"
                                        onclick="showUser({{ $user->id }});">✎</button>
                                    <a href="{{ route('deleteuser', $user->id) }}" class="btn btn-sm btn-light">🗑️</a>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>
<!-- Edit User Modal -->
<div class="modal modal-lg fade" id="editusermodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('updateuser') }} ">
                    @csrf
                    <div class="mb-3">
                        <label for="edituser_email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="edituser_email" name="email"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="edituser_name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="edituser_name" name="name"
                            aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3">
                        <label for="edituser_password" class="form-label">New password</label>
                        <input type="password" class="form-control" id="edituser_password" name="password">
                        <input type="hidden" class="form-control" id="edituser_id" name="id">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection