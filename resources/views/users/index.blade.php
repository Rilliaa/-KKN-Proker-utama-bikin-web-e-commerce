@extends('adminlte::page')
@section('title', 'List User')
@section('content_header')
    <h1 class="m-0 text-dark">Admin</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{route('users.create')}}" class="btn btn-primary mb-2">
                        <i class="fas fa-plus"></i> Tambah
                    </a>
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr style="text-align: center">
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Aksi</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$user->name}}</td>
                                <td >{{$user->email}}</td>
                                <td  style="text-align: center">
                                    {{-- <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                     --}}
                                    <form action="{{ route('user.destroy', $user->id)}}" method="POST" style="display:inline;" >
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger"  type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" >
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                        {{-- <a href="{{route('users.destroy', $user->id)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs"> --}}
                                        {{-- </a> --}}
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop












