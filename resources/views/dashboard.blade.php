@extends('layouts.app')

@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="ms-3">
                <h3 class="mb-0 h4 font-weight-bolder">Dashboard Mahasiswa</h3>
                <p class="mb-4">
                    Selamat Datang , {{ session('mahasiswa_data.name') }}!
                </p>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Nama</p>
                                <h4 class="mb-0">{{ session('mahasiswa_data.name') }}</h4>
                            </div>
                            <div
                                class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">person</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">NIM</p>
                                <h4 class="mb-0">{{ session('mahasiswa_data.nim') }}</h4>
                            </div>
                            <div
                                class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">badge</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Program Studi</p>
                                <h4 class="mb-0">{{ session('mahasiswa_data.prodi.nama_prodi') }}</h4>
                            </div>
                            <div
                                class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">school</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder"></span></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-header p-2 ps-3">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="text-sm mb-0 text-capitalize">Jumlah SKS</p>
                                <h4 class="mb-0">{{ session('mahasiswa_data.mahasiswa.jumlah_sks') }}</h4>
                            </div>
                            <div
                                class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                <i class="material-symbols-rounded opacity-10">weekend</i>
                            </div>
                        </div>
                    </div>
                    <hr class="dark horizontal my-0">
                    <div class="card-footer p-2 ps-3">
                        <p class="mb-0 text-sm"><span class="text-success font-weight-bolder"></span></p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Section Jadwal KKN dan Alur KKN --}}
        <div class="row mt-4 mb-4">
            <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row">
                            <div class="col-lg-6 col-7">
                                <h6>Jadwal KKN</h6>
                                <p class="text-sm mb-0">
                                    <i class="fa fa-check text-info" aria-hidden="true"></i>
                                    <span class="font-weight-bold ms-1">Program Studi</span> Yang Dibuka
                                </p>
                            </div>
                            <div class="col-lg-6 col-5 my-auto text-end">
                                <div class="dropdown float-lg-end pe-4">
                                    <a class="cursor-pointer" id="dropdownTable" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa fa-ellipsis-v text-secondary"></i>
                                    </a>
                                    <ul class="dropdown-menu px-2 py-3 ms-sm-n4 ms-n5" aria-labelledby="dropdownTable">
                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">Action</a>
                                        </li>
                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">Another
                                                action</a></li>
                                        <li><a class="dropdown-item border-radius-md" href="javascript:;">Something
                                                else here</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Program Studi</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Tahun Akademik</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Dibuka</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal Ditututp</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($jadwal_kkn as $jadwal)
                                        <tr>
                                            {{-- Kolom Prodi --}}
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">
                                                            {{-- $jadwal['prodi']['nama_prodi'] (Ini sudah benar) --}}
                                                            {{ $jadwal['prodi']['nama_prodi'] ?? 'Prodi T/A' }}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Kolom Tahun Akademik (INI PERBAIKANNYA) --}}
                                            <td>
                                                <h6 class="mb-0 text-sm text">
                                                    {{-- Key-nya adalah 'tahun' dan 'semester', bukan 'nama_tahun' --}}
                                                    {{ $jadwal['tahun_akademik']['tahun'] ?? '' }}
                                                    ({{ $jadwal['tahun_akademik']['semester'] ?? 'N/A' }})
                                                </h6>
                                            </td>

                                            {{-- Kolom Tanggal Dibuka (Ini sudah benar) --}}
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($jadwal['tanggal_dibuka'])->format('d M Y') }}
                                                </span>
                                            </td>

                                            {{-- Kolom Tanggal Ditutup (Ini sudah benar) --}}
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">
                                                    {{ \Carbon\Carbon::parse($jadwal['tanggal_ditutup'])->format('d M Y') }}
                                                </span>
                                            </td>

                                            {{-- Kolom Status (Baru, karena datanya ada) --}}
                                            <td class="align-middle text-center text-sm">
                                                @if ($jadwal['status_pendaftaran'])
                                                    <span class="badge badge-sm bg-gradient-success">Dibuka</span>
                                                @else
                                                    <span class="badge badge-sm bg-gradient-secondary">Ditutup</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            {{-- Sesuaikan colspan menjadi 5 karena kita tambah 1 kolom --}}
                                            <td colspan="5" class="align-middle text-center text-sm py-3">
                                                <span class="text-xs font-weight-bold"> Tidak Ada Jadwal KKN yang Dibuka </span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header pb-0">
                        <h6>Alur KKN</h6>
                        <p class="text-sm">
                            {{-- Konten
                        <p> diubah untuk relevansi --}}
                            Tahapan dari pendaftaran hingga selesai.
                        </p>
                    </div>
                    <div class="card-body p-3">
                        <div class="timeline timeline-one-side">

                            {{-- Tahap 1: Pengecekan Syarat --}}
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-symbols-rounded text-success text-gradient">fact_check</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Pengecekan Syarat</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">SKS, Status, & Jadwal Aktif
                                    </p>
                                </div>
                            </div>

                            {{-- Tahap 2: Pendaftaran & Pilih Jenis --}}
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-symbols-rounded text-danger text-gradient">how_to_reg</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Pendaftaran & Pilih Jenis KKN</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Memilih KKN yang tersedia
                                    </p>
                                </div>
                            </div>

                            {{-- Tahap 3: Pembayaran --}}
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-symbols-rounded text-info text-gradient">payments</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Pembayaran Biaya KKN</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Konfirmasi via Midtrans</p>
                                </div>
                            </div>

                            {{-- Tahap 4: Penentuan Lokasi/Mentor --}}
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-symbols-rounded text-warning text-gradient">groups</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Penentuan Lokasi & DPL</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Plotting oleh Panitia</p>
                                </div>
                            </div>

                            {{-- Tahap 5: Pelaksanaan --}}
                            <div class="timeline-block mb-3">
                                <span class="timeline-step">
                                    <i class="material-symbols-rounded text-primary text-gradient">event_note</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Pelaksanaan KKN</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Pengisian logbook &
                                        bimbingan</p>
                                </div>
                            </div>

                            {{-- Tahap 6: Selesai --}}
                            <div class="timeline-block">
                                <span class="timeline-step">
                                    <i class="material-symbols-rounded text-dark text-gradient">task_alt</i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0">Laporan & Penilaian</h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">KKN Selesai</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer --}}
        @include('layouts.footer')
        {{-- End footer --}}
    </div>
@endsection