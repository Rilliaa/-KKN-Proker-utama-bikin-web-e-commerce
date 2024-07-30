<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UMKM PRODUCTS</title>
</head>
<body>
    {{-- Halaman Guest / tamu  --}}
    halaman awal
    <div class="card-body">
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
