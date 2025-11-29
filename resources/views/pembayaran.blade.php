@extends('layouts.app')
@section('content')
  <div class="container-fluid py-2">
    <div class="row">
      <div class="col-12 mt-2">
        <div class="card">
          <div class="card-body pt-4 p-3">

            {{-- Jika ada pembayaran pending --}}
            @if ($pendingPayment)
              <div class="row">
                <div class="col-12">
                  <div class="card text-center p-4">
                    <div class="card-body">
                      <h5 class="font-weight-bolder mb-3">Anda Memiliki Transaksi Tertunda</h5>
                      <p class="text-secondary mb-4">
                        Selesaikan pembayaran untuk <strong>{{ $pendingPayment->order_id }}</strong>
                      </p>

                      <div class="d-flex gap-2 justify-content-center flex-wrap">
                        <button onclick="snap.pay('{{ $pendingPayment->snap_token }}')" class="btn btn-success px-3">
                          <i class="fas fa-credit-card"></i> Bayar Sekarang
                        </button>

                        <form action="{{ route('mahasiswa.pembayaran.cancel', ['id' => $pendingPayment->id]) }}"
                          method="POST" style="display: inline-block;"
                          onsubmit="return confirm('Anda yakin ingin membatalkan transaksi {{ $pendingPayment->order_id }}?');">
                          @csrf
                          <button type="submit" class="btn btn-danger px-3">
                            <i class="fas fa-times"></i> Batalkan Pembayaran
                          </button>
                        </form>

                        <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-outline-dark px-3">
                          <i class="fas fa-history"></i> Lihat Riwayat
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              {{-- Jika belum daftar KKN --}}
            @elseif ($mahasiswa->status_kkn === 'Belum Daftar')
              <div class="card">
                <div class="card-body p-4">
                  <div class="row g-3 px-3">
                    <h5 class="mb-2 fw-bold">Pembayaran KKN</h5>

                    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                      <div class="card">
                        <div class="card-body px-0 pb-2">
                          <div class="table-responsive">
                            <table class="table align-items-center mb-0">
                              <thead>
                                <tr>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Jenis KKN</th>
                                  <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Biaya</th>
                                  <th
                                    class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                    Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                @forelse ($jenisKknList as $jenis)
                                  <tr>
                                    {{-- Kolom Prodi --}}
                                    <td>
                                      <div class="d-flex px-2 py-1">
                                        <div class="d-flex flex-column justify-content-center">
                                          <h6 class="mb-0 text-sm">
                                            {{ $jenis['nama_jenis'] }}
                                          </h6>
                                        </div>
                                      </div>
                                    </td>
                                    <td>
                                      <h6 class="mb-0 text-sm text">
                                        Rp {{ number_format($jenis['biaya']) }}
                                      </h6>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                      {{-- @if ($jenis['is_active'])
                                      <span class="badge badge-sm bg-gradient-success">Aktif</span>
                                      @else
                                      <span class="badge badge-sm bg-gradient-secondary">Nonaktif</span>
                                      @endif --}}
                                    </td>
                                  </tr>
                                @empty
                                  <tr>
                                    <td colspan="3" class="text-center text-secondary">
                                      Tidak ada jenis KKN tersedia.
                                    </td>
                                  </tr>
                                @endforelse
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label class="form-label fw-bold">Pilih Jenis KKN</label>
                      <select id="jenis-kkn" class="form-select border"
                        style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                        <option value="">- Memuat Jenis KKN -</option>

                        @forelse($jenisKknList as $jenis)
                          <option value="{{ $jenis['id'] }}">
                            {{ $jenis['nama_jenis'] }} (Rp {{ number_format($jenis['biaya']) }})
                        </option> @empty <option value="" disabled>Gagal memuat jenis KKN</option>
                        @endforelse
                      </select>
                    </div>

                    <div class="col-12 text-end mt-4">
                      <button id="bayar-button" class="btn btn-success px-3">
                        <i class="fas fa-credit-card"></i>Bayar
                      </button>
                    </div>

                  </div>
                </div>
              </div>

              {{-- Jika sudah daftar --}}
            @else
              <div class="text-center alert alert-success p-4">
                <i class="fas fa-check-circle me-2"></i>
                <strong class="text-white">Anda sudah terdaftar KKN.</strong>
              </div>
            @endif

            {{-- Script Midtrans --}}
            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
              data-client-key="{{ config('midtrans.client_key') }}"></script>

            {{-- SweetAlert --}}
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            {{-- Script Pembayaran --}}
            <script>
              document.addEventListener('DOMContentLoaded', function () {
                const bayarBtn = document.getElementById('bayar-button');
                const jenisSelect = document.getElementById('jenis-kkn');

                bayarBtn.addEventListener('click', function () {
                  const jenisKknId = jenisSelect.value;

                  if (!jenisKknId) {
                    Swal.fire({
                      icon: 'warning',
                      title: 'Jenis KKN Belum Dipilih',
                      text: 'Silakan pilih jenis KKN terlebih dahulu.'
                    });
                    return;
                  }

                  Swal.fire({
                    title: 'Konfirmasi Pembayaran',
                    text: 'Lanjutkan ke proses pembayaran KKN?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Lanjut Bayar',
                    cancelButtonText: 'Batal',
                  }).then((result) => {
                    if (!result.isConfirmed) return;

                    bayarBtn.disabled = true;
                    bayarBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';

                    fetch("{{ route('mahasiswa.pembayaran.daftar') }}", {
                      method: 'POST',
                      headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                      },
                      body: JSON.stringify({ jenis_kkn_id: jenisKknId })
                    })
                      .then(async response => {
                        const data = await response.json();

                        // kalau gagal (HTTP 400/422/500)
                        if (!response.ok) {
                          throw new Error(data.message || "Terjadi kesalahan");
                        }

                        return data;
                      })
                      .then(data => {
                        if (!data.snap_token) throw new Error('Gagal membuat transaksi');

                        snap.pay(data.snap_token, {
                          onSuccess: function () { window.location.reload(); },
                          onPending: function () { window.location.reload(); },
                          onError: function () { window.location.reload(); },
                          onClose: function () {
                            window.location.reload();
                            bayarBtn.disabled = false;
                            bayarBtn.innerHTML = '<i class="fas fa-credit-card me-1"></i>Bayar';
                          }
                        });
                      })
                      .catch(err => {
                        Swal.fire({
                          icon: 'error',
                          title: 'Gagal',
                          text: err.message
                        });

                        bayarBtn.disabled = false;
                        bayarBtn.innerHTML = '<i class="fas fa-credit-card me-1"></i>Bayar';
                      });
                  });
                });
              });
            </script>

          </div>
        </div>
      </div>
    </div>

    {{-- Footer --}}
    @include('layouts.footer')
</div> @endsection