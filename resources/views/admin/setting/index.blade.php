@extends('admin.layouts.main')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid mt-3">
                <div class="col-12">
                    <form action="{{ route('main.updatesetting') }}" id="updateImageForm" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-7 col-sm-12 col-md-12">
                                <div class="card rounded-lg">
                                    <div class="card-body table-responsive">
                                        <div class="form-group mb-3">
                                            <label for="dusun">Website</label>
                                            <input type="text" value="{{ $setting->site_name }}" class="form-control"
                                                name="site_name" placeholder="Nama Website">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="keyword">Keyword</label>
                                            <input type="text" value="{{ $setting->keyword }}" class="form-control"
                                                name="keyword" placeholder="Keyword">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="email">Email</label>
                                            <input type="text" value="{{ $setting->email }}" class="form-control"
                                                name="email" placeholder="Email">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" value="{{ $setting->address }}" class="form-control"
                                                name="address" placeholder="Alamat">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="phone">Nomor Telepon</label>
                                            <input type="number" value="{{ $setting->phone }}" class="form-control"
                                                name="phone" placeholder="Alamat">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alamat">Url Instagram</label>
                                            <input type="text" value="{{ $setting->ig }}" class="form-control"
                                                name="ig" placeholder="">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alamat">Url Facebook</label>
                                            <input type="text" value="{{ $setting->fb }}" class="form-control"
                                                name="fb" placeholder="">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="alamat">Url Youtube</label>
                                            <input type="text" value="{{ $setting->yt }}" class="form-control"
                                                name="yt" placeholder="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-sm-12 col-md-12">
                                <div class="card rounded-lg">
                                    <div class="card-body table-responsive">
                                        <div class="form-group mb-3">
                                            <label for="dusun">Logo Website</label>
                                            <center>
                                                @if ($setting->logo != '')
                                                    <img id="blah" class='img-fluid mb-3' width='280'
                                                        src="{{ asset('storage/' . $setting->logo) }}" alt="your image" />
                                                @else
                                                    <img id="blah" class='img-fluid mb-3' width='280'
                                                        src="{{ asset('nofoto.jpg') }}" alt="your image" />
                                                @endif
                                            </center>
                                            <input type="file" name="logo" accept="image/*"
                                                class="form-control mb-3 bersih" onchange="readURL(this);"
                                                aria-describedby="inputGroupFileAddon01">
                                            <span class="badge badge-warning mb-3"><strong>Informasi</strong> Input Logo
                                                Maksimal
                                                3mb !</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card rounded-lg">
                                <div class="card-body table-responsive">
                                    <div class="form-group mb-3">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea name="description" class="form-control" id="">{{ $setting->description }}</textarea>
                                        {{-- <input type="text" value="{{ $setting->description }}" class="form-control" name="description" placeholder="description"> --}}
                                    </div>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>

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
            })
            $('#updateImageForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var url = $(this).attr("action");
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
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
                            text: data.success
                        }).then(function() {
                            // Optional: reload the page or update image preview
                            location.reload(); // Reload the page
                        });
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseJSON);

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

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection
