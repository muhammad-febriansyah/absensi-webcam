@extends('pegawai.layouts.main')
@section('content')
    <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar mr-2">
                    @if (Auth::user()->image != null)
                        <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="avatar" class="imaged w64 rounded">
                    @else
                        <img src="{{ asset('pria.png') }}" alt="avatar" class="imaged w64 rounded">
                    @endif
                </div>
                <div id="user-info mb-5">
                    <h3 id="user-name">{{ Auth::user()->name }}</h3>
                    <span id="user-role">{{ Auth::user()->jabatan->name }}</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">

                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('pegawai.cuti') }}" class="danger" style="font-size: 40px;">
                                    <ion-icon name="calendar"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Cuti</span>
                            </div>
                        </div>
                        
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="{{ route('pegawai.lokasi') }}" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a class="primary" style="font-size: 40px;" href="{{ route('pegawai.logout') }}"
                                    onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                    <ion-icon name="log-out"></ion-icon>
                                </a>
                                <form id="logout-form" action="{{ route('pegawai.logout') }}" method="POST">
                                    @csrf
                                </form>

                            </div>
                            <div class="menu-name">
                                Logout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-6">
                        <div class="card gradasigreen">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Absen Masuk</h4>
                                        <br>
                                        <br>
                                        <h4 class="presencedetail text-white">
                                            @if($checkmasuk > 0)
                                              Sudah Absen
                                                @else
                                              Belum Absen
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card gradasired">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="presencedetail">
                                        <h4 class="presencetitle">Absen Pulang</h4>
                                        <br>
                                        <br>
                                        <h4 class="presencedetail text-white">
                                            @if($checkpulang > 0)
                                              Sudah Absen
                                                @else
                                              Belum Absen
                                            @endif
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rekappresence">

                <div class="row">
                 
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence green">
                                        <ion-icon name="document-text"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Izin</h4>
                                        <span class="rekappresencedetail">{{ $izin }} Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="presencecontent">
                                    <div class="iconpresence warning">
                                        <ion-icon name="sad"></ion-icon>
                                    </div>
                                    <div class="presencedetail">
                                        <h4 class="rekappresencetitle">Sakit</h4>
                                        <span class="rekappresencedetail">{{ $sakit }} Hari</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
              
            </div>
            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Histori Absensi Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Histori Absensi Pulang
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($masuk as $row)
                                <li>
                                    <div class="item">
                                        <div class="icon-box bg-primary">
                                            <ion-icon name="finger-print-outline" role="img" class="md hydrated"
                                                aria-label="camera outline"></ion-icon>
                                        </div>
                                        <div class="in">
                                            <div>{{ date("d F Y g:i A", strtotime($row->datein)) }}</div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">
                            @foreach ($pulang as $row)
                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <ion-icon name="finger-print-outline" role="img" class="md hydrated"
                                            aria-label="camera outline"></ion-icon>
                                    </div>
                                    <div class="in">
                                        <div>{{ date("d F Y g:i A", strtotime($row->dateout)) }}</div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- * App Capsule -->


    <!-- App Bottom Menu -->
    @include('pegawai.layouts.bottomnav')
    <!-- * App Bottom Menu -->
@endsection
