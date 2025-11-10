@extends('layouts.app')

@section('content')
  <div class="container-fluid py-2">
    <div class="row">
      <div class="col-12 mt-2">
        <div class="card">
          {{-- <div class="card-header pb-0 px-3">
            <h6 class="mb-0">Billing Information</h6>
          </div> --}}
          <div class="card-body pt-4 p-3">
            @if ($mahasiswa->status_kkn === 'Belum Daftar')
              <div class="card p-3">
                <h5>Pendaftaran KKN</h5>
                <div class="mb-3">
                  <label for="jenis-kkn" class="form-label">Pilih Jenis KKN</label>
                  <select class="form-control" id="jenis-kkn">
                    <option value=""> Memuat Jenis KKN </option>
                    @forelse($jenisKknList as $jenis)
                      {{-- Ambil data dari variabel $jenis (array) --}}
                      <option value="{{ $jenis['id'] }}">
                        {{ $jenis['nama_jenis'] }} (Rp {{ number_format($jenis['biaya']) }})
                      </option>
                    @empty
                      <option value="" disabled>Gagal memuat jenis KKN</option>
                    @endforelse
                  </select>
                </div>

                <!-- tombol Daftar selalu terlihat, tombol Bayar muncul saat pilihan dipilih -->
                <button id="daftar-button" class="btn btn-primary">
                  Daftar
                </button>
                <button id="bayar-button" class="btn btn-success d-none">
                  Bayar
                </button>
              </div>
            @else
              <div class="text-center text-white alert alert-success">Anda sudah terdaftar KKN.</div>
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
                  btn.innerHTML = 'Memproses...';
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

                  if (daftarBtn.textContent.trim().toLowerCase() === 'bayar') {
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
@endsection