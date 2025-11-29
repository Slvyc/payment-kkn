@extends('layouts.app')
@section('content')
    <div class="container-fluid py-2">
        <div class="row">
            <div class="col-12 mt-2">
                <div class="card">
                    <div class="card-body pt-4 p-3">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body p-4">
                                        @if ($mahasiswa->status_kkn === 'Belum Daftar')
                                            <form action="{{ route('mahasiswa.biodata.update') }}" method="POST" id="biodataForm">
                                                @csrf
                                                <div class="row g-3 px-3">
                                                    <h5>Pendaftaran KKN</h5>
                                                    <!-- No HP -->
                                                    <div class="col-md-6">
                                                        <label for="no_hp" class="form-label fw-bold">No HP :</label>
                                                        <input type="text" class="form-control border" id="no_hp" name="no_hp"
                                                            value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                                                            placeholder="Masukkan nomor HP"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                    </div>

                                                    <!-- No HP Darurat -->
                                                    <div class="col-md-6">
                                                        <label for="no_hp_darurat" class="form-label fw-bold">No HP
                                                            Darurat :</label>
                                                        <input type="text" class="form-control border" id="no_hp_darurat"
                                                            name="no_hp_darurat" placeholder=" Masukkan nomor HP darurat" val
                                                            value="{{ old('no_hp_darurat', $mahasiswa->no_hp_darurat) }}"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                    </div>

                                                    <!-- Jenis Kelamin -->
                                                    <div class="col-md-6">
                                                        <label for="jenis_kelamin" class="form-label fw-bold">Jenis
                                                            Kelamin :</label>
                                                        <select class="form-select border" id="jenis_kelamin"
                                                            name="jenis_kelamin"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                            <option value="">- Pilih Jenis Kelamin -</option>
                                                            <option value="L" {{ $mahasiswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="P" {{ $mahasiswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                    </div>

                                                    <!-- Ukuran Jaket/Rompi -->
                                                    <div class="col-md-6">
                                                        <label for="ukuran_jacket_rompi" class="form-label fw-bold">Ukuran
                                                            Jaket/Rompi :</label>
                                                        <select class="form-select border" id="ukuran_jacket_rompi"
                                                            name="ukuran_jacket_rompi"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                            <option value="">- Pilih Rompi -</option>
                                                            @foreach(['S', 'M', 'L', 'XL', 'XXL', '3XL'] as $uk)
                                                                <option value="{{ $uk }}" {{ $mahasiswa->ukuran_jacket_rompi == $uk ? 'selected' : '' }}>
                                                                    {{ $uk }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Punya Kendaraan -->
                                                    <div class="col-md-6">
                                                        <label for="punya_kendaraan" class="form-label fw-bold">Mempunyai kendaraan :</label>
                                                        <select class="form-select border" id="punya_kendaraan"
                                                            name="punya_kendaraan"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                            <option value="">- Kepemilikan Kendaraan -</option>
                                                            <option value="Punya" {{ $mahasiswa->punya_kendaraan == 'Punya' ? 'selected' : '' }}>Ya</option>
                                                            <option value="Tidak" {{ $mahasiswa->punya_kendaraan == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                        </select>
                                                    </div>

                                                    <!-- Tipe Kendaraan  -->
                                                    <div class="col-md-6">
                                                        <label for="tipe_kendaraan" class="form-label fw-bold">Tipe kendaraan :</label>
                                                        <select class="form-select border" id="tipe_kendaraan"
                                                            name="tipe_kendaraan"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                            <option value="">- Tipe Kendaraan -</option>
                                                            <option value="Tidak Ada" {{ $mahasiswa->tipe_kendaraan == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada Kendaraan</option>
                                                            <option value="Mobil" {{ $mahasiswa->tipe_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                                            <option value="Sepeda Motor" {{ $mahasiswa->tipe_kendaraan == 'Sepeda Motor' ? 'selected' : '' }}>Sepeda Motor</option>
                                                        </select>
                                                    </div>

                                                    <!-- Punya Lisensi  -->
                                                    <div class="col-md-6">
                                                        <label for="punya_lisensi" class="form-label fw-bold">Mempunyai Lisensi :</label>
                                                        <select class="form-select border" id="punya_lisensi"
                                                            name="punya_lisensi"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                            <option value="">- Pilih Lisensi -</option>
                                                            @foreach(['Tidak Ada', 'SIM A', 'SIM B', 'SIM C', 'Lainnya'] as $lisensi)
                                                                <option value="{{ $lisensi }}" {{ $mahasiswa->punya_lisensi == $lisensi ? 'selected' : '' }}>
                                                                    {{ $lisensi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Keahlian -->
                                                    <div class="col-md-6">
                                                        <label for="keahlian" class="form-label fw-bold">Keahlian :</label>
                                                        <input type="text" class="form-control border" id="keahlian"
                                                            name="keahlian"
                                                            value="{{ old('keahlian', $mahasiswa->keahlian) }}" placeholder="Masukkan keahlian"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                                                    </div>

                                                    <!-- Tombol Submit -->
                                                    <div class="col-12 text-end mt-4">
                                                        <button type="submit" class="btn btn-primary px-3">
                                                            <i class="fas fa-save"></i>Simpan Biodata
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @else   
                                            <form action="" method="POST" id="biodataForm">
                                                @csrf
                                                <div class="row g-3 px-3">
                                                    <h5>Pendaftaran KKN</h5>
                                                    <!-- No HP -->
                                                    <div class="col-md-6">
                                                        <label for="no_hp" class="form-label fw-bold">No HP :</label>
                                                        <input type="text" class="form-control border" id="no_hp" name="no_hp"
                                                            value="{{ old('no_hp', $mahasiswa->no_hp) }}"
                                                            placeholder="Masukkan nomor HP"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                    </div>

                                                    <!-- No HP Darurat -->
                                                    <div class="col-md-6">
                                                        <label for="no_hp_darurat" class="form-label fw-bold">No HP
                                                            Darurat :</label>
                                                        <input type="text" class="form-control border" id="no_hp_darurat"
                                                            name="no_hp_darurat" placeholder=" Masukkan nomor HP darurat" val
                                                            value="{{ old('no_hp_darurat', $mahasiswa->no_hp_darurat) }}"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                    </div>

                                                    <!-- Jenis Kelamin -->
                                                    <div class="col-md-6">
                                                        <label for="jenis_kelamin" class="form-label fw-bold">Jenis
                                                            Kelamin :</label>
                                                        <select class="form-select border" id="jenis_kelamin"
                                                            name="jenis_kelamin"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                            <option value="">- Pilih Jenis Kelamin -</option>
                                                            <option value="L" {{ $mahasiswa->jenis_kelamin == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                                            <option value="P" {{ $mahasiswa->jenis_kelamin == 'P' ? 'selected' : '' }}>Perempuan</option>
                                                        </select>
                                                    </div>

                                                    <!-- Ukuran Jaket/Rompi -->
                                                    <div class="col-md-6">
                                                        <label for="ukuran_jacket_rompi" class="form-label fw-bold">Ukuran
                                                            Jaket/Rompi :</label>
                                                        <select class="form-select border" id="ukuran_jacket_rompi"
                                                            name="ukuran_jacket_rompi"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                            <option value="">- Pilih Rompi -</option>
                                                            @foreach(['S', 'M', 'L', 'XL', 'XXL', '3XL'] as $uk)
                                                                <option value="{{ $uk }}" {{ $mahasiswa->ukuran_jacket_rompi == $uk ? 'selected' : '' }}>
                                                                    {{ $uk }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Punya Kendaraan -->
                                                    <div class="col-md-6">
                                                        <label for="punya_kendaraan" class="form-label fw-bold">Mempunyai kendaraan :</label>
                                                        <select class="form-select border" id="punya_kendaraan"
                                                            name="punya_kendaraan"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                            <option value="">- Kepemilikan Kendaraan -</option>
                                                            <option value="Punya" {{ $mahasiswa->punya_kendaraan == 'Punya' ? 'selected' : '' }}>Ya</option>
                                                            <option value="Tidak" {{ $mahasiswa->punya_kendaraan == 'Tidak' ? 'selected' : '' }}>Tidak</option>
                                                        </select>
                                                    </div>

                                                    <!-- Tipe Kendaraan  -->
                                                    <div class="col-md-6">
                                                        <label for="tipe_kendaraan" class="form-label fw-bold">Tipe kendaraan :</label>
                                                        <select class="form-select border" id="tipe_kendaraan"
                                                            name="tipe_kendaraan"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                            <option value="">- Kepemilikan Kendaraan -</option>
                                                            <option value="Tidak Ada" {{ $mahasiswa->tipe_kendaraan == 'Tidak Ada' ? 'selected' : '' }}>Mobil</option>
                                                            <option value="Mobil" {{ $mahasiswa->tipe_kendaraan == 'Mobil' ? 'selected' : '' }}>Mobil</option>
                                                            <option value="Sepeda Motor" {{ $mahasiswa->tipe_kendaraan == 'Sepeda Motor' ? 'selected' : '' }}>Sepeda Motor</option>
                                                        </select>
                                                    </div>

                                                    <!-- Punya Lisensi  -->
                                                    <div class="col-md-6">
                                                        <label for="punya_lisensi" class="form-label fw-bold">Mempunyai Lisensi :</label>
                                                        <select class="form-select border" id="punya_lisensi"
                                                            name="punya_lisensi"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                            <option value="">- Pilih Lisensi -</option>
                                                            @foreach(['Tidak Ada', 'SIM A', 'SIM B', 'SIM C', 'Lainnya'] as $lisensi)
                                                                <option value="{{ $lisensi }}" {{ $mahasiswa->punya_lisensi == $lisensi ? 'selected' : '' }}>
                                                                    {{ $lisensi }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Keahlian -->
                                                    <div class="col-md-6">
                                                        <label for="keahlian" class="form-label fw-bold">Keahlian :</label>
                                                        <input type="text" class="form-control border" id="keahlian"
                                                            name="keahlian"
                                                            value="{{ old('keahlian', $mahasiswa->keahlian) }}" placeholder="Masukkan keahlian"
                                                            style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;"
                                                            disabled>
                                                    </div>

                                                    <!-- Tombol Submit -->
                                                    <div class="col-12 text-end mt-4">
                                                        <button type="submit" class="btn btn-primary px-3" disabled>
                                                            <i class="fas fa-save"></i>Simpan Biodata
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
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

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Script Konfirmasi Submit --}}
    <script>
        document.getElementById('biodataForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Data',
                text: 'Anda yakin data yang Anda masukkan sudah benar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>

    {{-- error/success/warning handle sweet alert --}}
    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                customClass: {
                popup: 'glass-popup rounded-3xl shadow-blur p-6',
                title: 'font-semibold',
                icon: 'icon-custom bg-transparent'
                },
                timer: 2000
            });
        @elseif (session('warning'))
            Swal.fire({
                icon: 'warning',
                text: "{{ session('warning') }}",
                showConfirmButton: false,
                customClass: {
                popup: 'glass-popup rounded-3xl shadow-blur p-6',
                title: 'font-semibold',
                icon: 'icon-custom bg-transparent'
                },
                timer: 2000
            });
        @endif

        @if($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                customClass: {
                popup: 'glass-popup rounded-3xl shadow-blur p-6',
                title: 'font-bold',
                confirmButton: 'button-confirm px-6 py-2 rounded-xl text-white',
                }
            });
        @endif
    </script>
@endsection