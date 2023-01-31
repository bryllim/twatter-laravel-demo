<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Twatter - @yield('title')</title>
    <style>
        body {
            background: url("https://w0.peakpx.com/wallpaper/239/25/HD-wallpaper-abstract-design-minimal-abstract-blue-white-dark-blue-design-flat-lines-modern-simple.jpg") no-repeat center center; 
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

    </style>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Datatable -->
    <link href="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/vanilla-datatables@latest/dist/vanilla-dataTables.min.js" type="text/javascript"></script>
    @vite('resources/js/app.js')
</head>

<body>
    <div id="app">
        @include('layouts.nav')
        <main class="py-4">
            @yield('content')
        </main>
        @include('layouts.footer')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script>
    <script>
    const dataTable = new DataTable("#usermanagement");

    const editUserModal = new bootstrap.Modal('#editusermodal', {
        keyboard: false
    });
    
    function showUser(user_id){
        fetch('{{ url('/users/') }}/' + user_id)
        .then(response => response.json())
        .then(data => {
            document.getElementById('edituser_email').value = data.email;
            document.getElementById('edituser_name').value = data.name;
            document.getElementById('edituser_id').value = data.id;
            editUserModal.show();
        })
    }

    function imageUpload(event){
        let imageInput = document.getElementById('image');
        document.getElementById("imageUploadLabel").remove();

        let img = new Image();
        img.src = URL.createObjectURL(event.target.files[0]);
        img.classList.add("img-thumbnail");
        img.classList.add("mt-2");
        document.getElementById('imageArea').appendChild(img);
    }
    </script>
</body>

</html>