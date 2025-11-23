@extends('layouts.app')
@section('content')
  <div class="container-fluid py-2">
    <div class="row">
      <div class="col-12 mt-2">
        <div class="card">
          <div class="card-body pt-4 p-3">
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
                        <button onclick="snap.pay('{{ $pendingPayment->snap_token }}')" class="btn btn-success px-4">
                          <i class="fas fa-credit-card me-2"></i>Bayar Sekarang
                        </button>
                        <form action="{{ route('mahasiswa.pembayaran.cancel', ['id' => $pendingPayment->id]) }}"
                          method="POST" style="display: inline-block;"
                          onsubmit="return confirm('Anda yakin ingin membatalkan transaksi {{ $pendingPayment->order_id }}?');">
                          @csrf
                          <button type="submit" class="btn btn-danger px-4">
                            <i class="fas fa-times me-2"></i>Batalkan Pembayaran
                          </button>
                        </form>
                        <a href="{{ route('mahasiswa.riwayat') }}" class="btn btn-outline-dark px-4">
                          <i class="fas fa-history me-2"></i>Lihat Riwayat
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @elseif ($mahasiswa->status_kkn === 'Belum Daftar')
              <div class="card">
                <div class="card-body p-4">
                  <div class="row g-3 px-3">
                    <h5 class="mb-2 fw-bold">Pembayaran KKN</h5>
                    <div class="col-12">
                      <label for="jenis-kkn" class="form-label fw-bold">Pilih Jenis KKN</label>
                      <select class="form-select border" id="jenis-kkn"
                        style="border: 1px solid #d2d6da !important; padding: 0.5rem 0.75rem;">
                        <option value="">- Memuat Jenis KKN -</option>
                        @forelse($jenisKknList as $jenis)
                          <option value="{{ $jenis['id'] }}">
                            {{ $jenis['nama_jenis'] }} (Rp {{ number_format($jenis['biaya']) }})
                          </option>
                        @empty
                          <option value="" disabled>Gagal memuat jenis KKN</option>
                        @endforelse
                      </select>
                    </div>

                    <div class="col-12 text-end mt-4">
                      <button id="daftar-button" class="btn btn-primary px-3">
                        <i class="fas fa-check-circle"></i>Daftar
                      </button>
                      <button id="bayar-button" class="btn btn-success px-3 d-none">
                        <i class="fas fa-credit-card"></i>Bayar
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            @else
              <div class="text-center alert alert-success p-4">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Anda sudah terdaftar KKN.</strong>
              </div>
            @endif

            {{-- Script Midtrans (taruh di layout utama) --}}
            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
              data-client-key="{{ config('midtrans.client_key') }}"></script>

            {{-- Script Logika Halaman (taruh di bawah) --}}
            <script type="text/javascript">
              (function () {
                const jenisSelect = document.getElementById('jenis-kkn');
                const daftarBtn = document.getElementById('daftar-button');
                const bayarBtn = document.getElementById('bayar-button');

                // helper: jalankan proses pembayaran (dipakai oleh tombol Bayar / Daftar ketika sudah berubah)
                function processPayment(jenisKknId, btn) {
                  if (!jenisKknId) return alert('Pilih jenis KKN terlebih dahulu.');

                  const originalText = btn.innerHTML;
                  btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
                  btn.disabled = true;

                  fetch("{{ route('mahasiswa.pembayaran.daftar') }}", {
                    method: 'POST',
                    headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ jenis_kkn_id: jenisKknId })
                  })
                    .then(response => response.json())
                    .then(data => {
                      if (data.snap_token) {
                        window.snap.pay(data.snap_token, {
                          onSuccess: function () { window.location.reload(); },
                          onPending: function () { window.location.reload(); },
                          onError: function () { window.location.reload(); },
                          onClose: function () {
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                          }
                        });
                      } else {
                        throw new Error(data.message || 'Gagal memproses pembayaran');
                      }
                    })
                    .catch(err => {
                      alert('Error: ' + (err.message || err));
                      btn.innerHTML = originalText;
                      btn.disabled = false;
                    });
                }

                // klik tombol utama: jika teks "Bayar" -> proses pembayaran, kalau "Daftar" -> tampilkan bayar
                daftarBtn.addEventListener('click', function () {
                  const jenisKknId = jenisSelect.value;
                  if (!jenisKknId) {
                    alert('Pilih jenis KKN terlebih dahulu.');
                    return;
                  }

                  if (daftarBtn.textContent.trim().toLowerCase().includes('bayar')) {
                    processPayment(jenisKknId, daftarBtn);
                    return;
                  }

                  // fallback: tampilkan tombol bayar dan scroll ke situ
                  bayarBtn.classList.remove('d-none');
                  bayarBtn.scrollIntoView({ behavior: 'smooth', block: 'center' });
                });

                // jika user klik tombol bayar sekunder, panggil processPayment juga
                bayarBtn.addEventListener('click', function () {
                  processPayment(jenisSelect.value, bayarBtn);
                });
              })();
            </script>
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
  {{-- <script>
    document.getElementById('daftarForm').addEventListener('submit', function (e) {
      e.preventDefault();

      Swal.fire({
        title: 'Konfirmasi Data',
        text: 'Anda yakin anda KKN yang anda masukkan sudah benar?',
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
  </script> --}}

  {{-- Script Error Atau Sukses --}}
@endsection