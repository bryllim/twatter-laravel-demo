@extends('layouts.app')

@section('title', 'Profile')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card p-4">
                <h1 class="fw-bold">{{ $user->name }}</h1>
                <p>
                    {{ $user->email }}
                    <br>
                    <span class="mb-3 badge text-bg-primary">Joined on {{ date_format($user->created_at, "F j, Y") }}</span>
                    <br>
                    <a href="{{ route('home') }} ">← Back to Home</a>
                    <hr>
                    <h4 class="fw-bold">
                        Recent Twats
                    </h4>
                    @foreach($user->twats as $twat)
                    <div class="card my-2">
                        <div class="card-body">
                            <h6 class="fw-bold">
                                {{ $twat->user->name }}
                                @if($twat->user_id == Auth::user()->id)
                                <a href="#" class="float-end dropdown-toggle" style="text-decoration:none" data-bs-toggle="dropdown"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('deletetwat', $twat->id) }}">Delete</a></li>
                                </ul>
                                @endif
                            </h6>
                            
                            <p>
                                {{ $twat->content}}
                            </p>
                            <small class="text-muted float-end">{{ $twat->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    @endforeach
                </p>
                

            </div>
        </div>
    </div>
</div>
@endsection