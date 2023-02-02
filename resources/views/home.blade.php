@extends('layouts.app')

@section('title', 'Home')
@section('content')
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
                @if(Auth::user()->type == 'admin')
                <a href="{{ route('admin') }}" class="btn btn-dark btn-sm mt-2">Admin Dashboard</a>
                @endif
                <hr>
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="btn btn-light btn-sm">← Logout</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
        <!-- Twats Section -->
        <div class="col-md-9">
            @if(session('success'))
            <div class="alert alert-primary" role="alert">
            {{session('success')}}
            </div>
            @endif
            <!-- Write Twat -->
            <div class="card p-3 mb-3">
                <p class="fw-bold">Write a Twat</p>
                <form action="{{ route('createtwat') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-10" id="imageArea">
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input class="form-control" placeholder="Say anything you want..." type="text" name="content">
                            
                            <input class="form-control d-none" type="file" name="image" id="image" accept=".gif,.jpg,.jpeg,.png" onchange="imageUpload(event);">
                            <label class="mt-2 bg-primary text-white rounded px-2 py-1 fw-bold" for="image" style="cursor: pointer;" id="imageUploadLabel"><small>⬆ Add a photo...</small></label>
                        </div>
                        <div class="col-2">
                            <button type="submit" class="btn btn-primary">
                                ➡
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-body">
                    <h2 class="fw-bold mb-3">Recent Twats</h2>
                    <!-- Twat Area -->
                    @foreach($twats as $twat)
                    <div class="card my-2">
                        <div class="card-body">
                            <h6 class="fw-bold">
                                <a href="{{ route('profile', $twat->user->id) }}" style="text-decoration:none">{{ $twat->user->name }}</a>
                                @if($twat->user_id == Auth::user()->id)
                                <a href="#" class="float-end dropdown-toggle" style="text-decoration:none" data-bs-toggle="dropdown"></a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('deletetwat', $twat->id) }}">Delete</a></li>
                                </ul>
                                @endif
                                <small class="text-muted float-end mx-3 fw-normal">⏲ {{ $twat->created_at->diffForHumans() }}</small>
                            </h6>
                            <p>
                                {{ $twat->content }}
                            </p>
                            @if($twat->image_path != NULL)
                            <img src="{{ Storage::url('images/'.$twat->image_path) }}" class="img-fluid">
                            @endif
                            <!-- Reactions -->
                            @if(!Auth::user()->hasReaction($twat->id))
                                <div class="d-flex">
                                    <form action="{{ route('reaction.create') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="reaction" id="reaction">
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                        <input type="hidden" name="twat_id" value="{{ $twat->id }}">
                                        <button type="submit" class="btn-light btn btn-sm rounded-pill" onclick="document.getElementById('reaction').value='like'">👍🏻</button>
                                        <button type="submit" class="btn-light btn btn-sm rounded-pill" onclick="document.getElementById('reaction').value='heart'">💙</button>
                                        <button type="submit" class="btn-light btn btn-sm rounded-pill" onclick="document.getElementById('reaction').value='laugh'">😂</button>
                                        <button type="submit" class="btn-light btn btn-sm rounded-pill" onclick="document.getElementById('reaction').value='angry'">😠</button>
                                        <button type="submit" class="btn-light btn btn-sm rounded-pill" onclick="document.getElementById('reaction').value='dislike'">👎🏻</button>
                                    </form>
                                </div>
                            @endif
                            <p>
                                {{-- Total like --}}
                                @if($twat->countReaction('like'))
                                <small><small><span class="badge bg-light text-dark">{{$twat->countReaction('like')}} 👍🏻</span></small></small>
                                @endif

                                {{-- Total heart --}}
                                @if($twat->countReaction('heart'))
                                <small><small><span class="badge bg-light text-dark">{{$twat->countReaction('heart')}} 💙</span></small></small>
                                @endif

                                {{-- Total laugh --}}
                                @if($twat->countReaction('laugh'))
                                <small><small><span class="badge bg-light text-dark">{{$twat->countReaction('laugh')}} 😂</span></small></small>
                                @endif

                                {{-- Total angry --}}
                                @if($twat->countReaction('angry'))
                                <small><small><span class="badge bg-light text-dark">{{$twat->countReaction('angry')}} 😠</span></small></small>
                                @endif

                                {{-- Total dislike --}}
                                @if($twat->countReaction('dislike'))
                                <small><small><span class="badge bg-light text-dark">{{$twat->countReaction('dislike')}} 👎🏻</span></small></small>
                                @endif
                            </p>
                            <hr>
                            <!-- Replies -->
                            @foreach($twat->replies as $reply)
                            <div class="card bg-light py-2 px-2 mb-2">
                                <small>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('profile', $reply->user->id) }}" style="text-decoration:none">{{ $reply->user->name }}</a>
                                        <div>
                                            <span class="text-muted"><small>⏲ {{ $reply->created_at->diffForHumans() }}</small></span>
                                            @if($reply->user->id == Auth::user()->id)
                                            <a href="#" class="dropdown-toggle" style="text-decoration:none" data-bs-toggle="dropdown"></a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('deletereply', $reply->id) }}">Delete</a></li>
                                            </ul>
                                            @endif
                                        </div>
                                    </div>
                                    {{ $reply->content }}
                                </small>
                            </div>
                            @endforeach
                            <form action="{{ route('createreply') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="text" class="form-control" placeholder="💬 Add a reply..." name="content" required>
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="twat_id" value="{{ $twat->id }}">
                                <button type="submit" class="d-none"></button>
                            </form>
                        </div>
                    </div>
                    @endforeach

                    {{ $twats->links() }}
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection