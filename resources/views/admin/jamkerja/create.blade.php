@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <form id="form">
                                @csrf
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Jam Masuk</label>
                                    <input type="text" class="form-control time" name="in" placeholder="Jabatan"
                                        id="formrow-firstname-input">
                                </div>
                                <div class="mb-3">
                                    <label for="formrow-firstname-input" class="form-label">Jam Keluar</label>
                                    <input type="text" class="form-control time" name="out" placeholder="Jabatan"
                                        id="formrow-firstname-input">
                                </div>
                                <div>
                                    <a href="{{ route('main.jamkerja') }}" class="btn btn-warning w-md"><i
                                            class="fas fa-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-primary w-md"><i class="fa fa-paper-plane"
                                            aria-hidden="true"></i> Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>

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
            $('.time').timepicker({
                timeFormat: 'H:i',
                interval: 30,
                minTime: '0',
                maxTime: '23:00',
                defaultTime: 'now',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
            $('#form').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('main.storejamkerja') }}',
                    data: $(this).serialize(),
                    beforeSend: function() {
                        Swal.fire({
                            title: 'Tunggu Sebentar...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                Swal.showLoading()
                            }
                        });
                    },
                    success: function(data) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Informasi',
                            text: "Data berhasil ditambahkan!"
                        }).then(function() {
                            location.reload(); // Reload the page
                        });
                    },
                    error: function(xhr, status, error) {
                        var errorMessage = xhr.status + ': ' + xhr.statusText;
                        Swal.fire({
                            icon: 'error',
                            title: 'Informasi',
                            text: 'Ada kesalahan sistem: ' + errorMessage
                        });
                    }
                });
            });

        });
    </script>
@endsection
