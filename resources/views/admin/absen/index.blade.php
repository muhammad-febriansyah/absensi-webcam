@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home1" role="tab">
                                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                                        <span class="d-none d-sm-block">Absensi Masuk</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile1" role="tab">
                                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                                        <span class="d-none d-sm-block">Absensi Pulang</span>
                                    </a>
                                </li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-3 text-muted">
                                <div class="tab-pane active" id="home1" role="tabpanel">
                                    <table class="table table-bordered table-hover" id="dt">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Pegawai</th>
                                                <th>Tgl</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($masuk as $data)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $data->foto_in) }}" alt=""
                                                            width="80px" height="80px"
                                                            class="img img-fluid img-thumbnail">
                                                    </td>
                                                    <td>{{ $data->user->name }}</td>
                                                    <td>{{ date('d F Y g:i A', strtotime($data->datein)) }}</td>
                                                    <td>
                                                        <a href="{{ route('main.detailAbsen',$data->id) }}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane" id="profile1" role="tabpanel">
                                    <table class="table table-bordered table-hover" id="dt">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Foto</th>
                                                <th>Pegawai</th>
                                                <th>Tgl</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($pulang as $data)
                                                <tr>
                                                    <td>{{ $no++ }}</td>
                                                    <td>
                                                        <img src="{{ asset('storage/' . $data->foto_in) }}" alt=""
                                                            width="80px" height="80px"
                                                            class="img img-fluid img-thumbnail">
                                                    </td>
                                                    <td>{{ $data->user->name }}</td>
                                                    <td>{{ date('d F Y g:i A', strtotime($data->datein)) }}</td>
                                                    <td>
                                                        <a href="{{ route('main.detailAbsenPulang',$data->id) }}" class="btn btn-primary"><i class="fa fa-eye" aria-hidden="true"></i> Detail</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div><!-- end card-body -->
                    </div><!-- end card -->

                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        @include('admin.layouts.footer')
    </div>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).on('click', '.approval', function() {
                var id = $(this).data("id");
                var url = "{{ route('main.approve') }}";
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Data yang sudah diapprove tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Setujui',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                id: id
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Tunggu Sebentar...',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    showConfirmButton: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                });
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Informasi',
                                    text: data.message,
                                }).then(function() {
                                    location.reload(); // Reload the page
                                });
                            },
                            error: function(data) {
                                console.log(data);
                                Swal.fire('Informasi', 'Ada kesalahan sistem.',
                                    'error');
                            }
                        });
                    }
                });
            });
            $(document).on('click', '.reject', function() {
                var id = $(this).data("id");
                var url = "{{ route('main.reject') }}";
                Swal.fire({
                    title: 'Apakah kamu yakin?',
                    text: 'Data yang sudah ditolak tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Tolak',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                id: id
                            },
                            beforeSend: function() {
                                Swal.fire({
                                    title: 'Tunggu Sebentar...',
                                    allowOutsideClick: false,
                                    allowEscapeKey: false,
                                    allowEnterKey: false,
                                    showConfirmButton: false,
                                    onBeforeOpen: () => {
                                        Swal.showLoading()
                                    },
                                });
                            },
                            success: function(data) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Informasi',
                                    text: data.message,
                                }).then(function() {
                                    location.reload(); // Reload the page
                                });
                            },
                            error: function(data) {
                                console.log(data);
                                Swal.fire('Informasi', 'Ada kesalahan sistem.',
                                    'error');
                            }
                        });
                    }
                });
            });



        });
    </script>
@endsection
