@extends('layouts.app')

@section('content')
  <div class="container-fluid py-2">
    <div class="row">
      <div class="col-12">
        <div class="row">
          <div class="col-xl-6">
            <div class="row">
              <div class="col-md-6 col-6">
              </div>
            </div>
          </div>
          <div class="col-md-12 mb-lg-0 mb-4">
            <div class="card mt-4">
              <div class="card-header pb-0 p-3">
                <div class="row">
                  <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Payment Method</h6>
                  </div>
                  <div class="col-6 text-end">
                    <a class="btn bg-gradient-dark mb-0" href="javascript:;"><i
                        class="material-symbols-rounded text-sm">add</i>&nbsp;&nbsp;Add New Card</a>
                  </div>
                </div>
              </div>
              <div class="card-body p-3">
                <div class="row">
                  <div class="col-md-6 mb-md-0 mb-4">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      {{-- <img class="w-10 me-3 mb-0" src="../assets/img/logos/mastercard.png" alt="logo"> --}}
                      <h6 class="mb-0">****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;7852</h6>
                      <i class="material-symbols-rounded ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Edit Card">edit</i>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card card-body border card-plain border-radius-lg d-flex align-items-center flex-row">
                      {{-- <img class="w-10 me-3 mb-0" src="../assets/img/logos/visa.png" alt="logo"> --}}
                      <h6 class="mb-0">****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;****&nbsp;&nbsp;&nbsp;5248</h6>
                      <i class="material-symbols-rounded ms-auto text-dark cursor-pointer" data-bs-toggle="tooltip"
                        data-bs-placement="top" title="Edit Card">edit</i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 mt-4">
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
                <button id="bayar-kkn-button" class="btn btn-success">
                  Daftar dan Bayar
                </button>
              </div>
            @else
              <div class="alert alert-success">Anda sudah terdaftar KKN.</div>
            @endif

            {{-- Script Midtrans (taruh di layout utama) --}}
            <script src="https://app.sandbox.midtrans.com/snap/snap.js"
              data-client-key="{{ config('midtrans.cliexnt_key') }}"></script>

            {{-- Script Logika Halaman (taruh di bawah) --}}
            <script type="text/javascript">
              // Memproses Pembayaran Saat Tombol Diklik ---
              document.getElementById('bayar-kkn-button').onclick = function () {
                const jenisKknId = document.getElementById('jenis-kkn').value;
                const button = this;
                button.innerHTML = "Memvalidasi...";
                button.disabled = true;

                fetch("{{ route('mahasiswa.pembayaran.daftar') }}", { // Panggil API KKN Payment
                  method: 'POST',
                  headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                  },
                  body: JSON.stringify({ jenis_kkn_id: jenisKknId })
                })
                  .then(response => {
                    if (!response.ok) return response.json().then(err => { throw new Error(err.message) });
                    return response.json();
                  })
                  .then(data => {
                    if (data.snap_token) {
                      // Munculkan Pop-up Midtrans
                      window.snap.pay(data.snap_token, {
                        onSuccess: function (result) { window.location.reload(); },
                        onPending: function (result) { window.location.reload(); },
                        onError: function (result) { window.location.reload(); },
                        onClose: function () {
                          button.innerHTML = "Daftar dan Bayar";
                          button.disabled = false;
                        }
                      });
                    }
                  })
                  .catch(error => {
                    alert('Error: ' + error.message); // Tampilkan error (cth: SKS kurang)
                    button.innerHTML = "Daftar dan Bayar";
                    button.disabled = false;
                  });
              };
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