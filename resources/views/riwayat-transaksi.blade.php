@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
    <div class="container-fluid py-2 mb-5">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
                            <h4 class="text-white text-capitalize ps-3">Riwayat Transaksi</h4>
                            <h6 class="text-white ps-3">Daftar semua transaksi pembayaran KKN Anda</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Order ID</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Jenis KKN</th>
                                        <th
                                            class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                            Jumlah</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Status</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Tanggal</th>
                                        <th
                                            class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            Aksi</th>
                                        <th class="text-secondary opacity-7"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($payments->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <div class="d-flex flex-column align-items-center">
                                                    <h6 class="mb-0 text-sm">Belum ada transaksi</h6>
                                                    <p class="text-xs text-secondary">Anda belum melakukan transaksi pembayaran
                                                    </p>
                                                    <a href="{{ route('mahasiswa.pembayaran') }}"
                                                        class="btn btn-primary btn-sm mt-2">
                                                        Daftar KKN Sekarang
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach($payments as $payment)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $payment->order_id }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $payment->jenis_kkn }}</p>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">
                                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p class="text-xs text-center font-weight-bold mb-0">
                                                        @if($payment->status == 'success')
                                                            <span class="badge badge-sm bg-gradient-success">Berhasil</span>
                                                        @elseif($payment->status == 'pending')
                                                            <span class="badge badge-sm bg-gradient-warning">Pending</span>
                                                        @else
                                                            <span class="badge badge-sm bg-gradient-danger">Gagal</span>
                                                        @endif
                                                    </p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    {{ $payment->created_at->format('d M Y, H:i') }}
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <a href="">
                                                        <span class="badge badge-sm bg-gradient-success">Print</span>
                                                    </a>
                                                    @if ($payment->status == 'pending' && $payment->snap_token)
                                                        <button onclick="bayarLagi('{{ $payment->snap_token }}')">
                                                            <span class="badge badge-sm bg-gradient-danger">Bayar Sekarang</span>
                                                        </button>
                                                    @elseif($payment->status == 'success')
                                                        <span class="badge badge-sm bg-gradient-success">Lunas</span>
                                                    @else
                                                        <span class="badge badge-sm bg-gradient-success">-</span>
                                                    @endif
                                                </td>
                                                {{-- <td class=" px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if($payment->status == 'pending' && $payment->snap_token)
                                                    <button onclick="bayarLagi('{{ $payment->snap_token }}')"
                                                        class="text-blue-600 hover:text-blue-900">
                                                        Bayar Sekarang
                                                    </button>
                                                    @elseif($payment->status == 'success')
                                                    <span class="text-green-600">Lunas</span>
                                                    @else
                                                    <span class="text-gray-400">-</span>
                                                    @endif
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        function bayarLagi(snapToken) {
            snap.pay(snapToken, {
                onSuccess: function (result) {
                    alert('Pembayaran berhasil!');
                    location.reload();
                },
                onPending: function (result) {
                    alert('Menunggu pembayaran...');
                },
                onError: function (result) {
                    alert('Pembayaran gagal!');
                },
                onClose: function () {
                    console.log('Popup ditutup');
                }
            });
        }
    </script>
@endsection