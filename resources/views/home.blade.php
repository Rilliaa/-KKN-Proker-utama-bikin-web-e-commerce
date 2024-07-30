@extends('adminlte::page')
@section('title', 'Dashboard Admin')
@section('content_header')
    <h1 class="m-0 text-dark d-flex jsutify-content-between">Dashboard Admin</h1>
@stop                                                                                                   

@section('content')
{{-- <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body d-flex justify-content-between">
                <div>
                    <p class="mr-auto">Selamat Datang, <strong style="color: #ff9e2a;">{{ Auth::user()->name }}</strong></p><br>
                    <span style="color: navy; text-weight:bold;">Sekarang Tanggal, <strong><i>{{$tglskrng}}</i></strong> Selamat Bekerja!</span>

                </div>
                <div class="ml-auto">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Buat Sesi Pembelajaran
                    </button>
                </div>
            </div>
            <div class="card-body d-flex justify-content-between" style="margin-top: -75px;">
                <div class="ml-auto">
                    <button type="button" class="btn btn-danger" id="btnLihat">
                        Lihat Sesi Pembelajaran
                    </button>
                </div>
            </div>
            <table class="table table-hover table-bordered table-stripped" style="display : none;" id="example2"  name="TabelKehadiran">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col" style="text-align: center">Tanggal</th>
                        <th scope="col" style="text-align: center">Hari</th>
                        <th scope="col" style="text-align: center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sesi as $data)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                  
                            <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-y') }}</td>
                            <td>{{ $data->hari }}</td>
                            <td style="text-align: center"><span id="status{{ $loop->iteration }}" style="border-radius: 5px; padding: 3px 8px; text-align: center;"></span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Buat Sesi Pembelajaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
      
                    <form id="bukaSesiForm">
                        <div class="form-group">
                            <label for="tanggal">Tanggal:</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal">
                        </div>
                        <div class="form-group">
                            <label for="hari">Hari:</label>
                            <select class="form-control" id="hari" name="hari" >
                                <option value="">Silahkan Pilih Tanggal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tahun_ajaran">Tahun Ajaran:</label>
                            <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran" placeholder="2021" value="{{$tahunIni}}">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="simpanSesiBtn">Simpan</button>
                </div>
            </div>
        </div>
    </div> --}}
@stop
