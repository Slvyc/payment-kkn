<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pembayaran KKN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fade-in {
            animation: fadeIn 0.5s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-hover:hover {
            transform: translateY(-5px);
            transition: all 0.3s;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
                    </svg>
                    <span class="text-xl font-bold text-gray-800">Universitas XYZ</span>
                </div>
                <button onclick="showPage('admin')" class="text-blue-600 hover:text-blue-800 font-medium">
                    Admin Login
                </button>
            </div>
        </div>
    </nav>

    <!-- Home Page -->
    <div id="homePage" class="container mx-auto px-4 py-12">
        <div class="max-w-4xl mx-auto fade-in">
            <div class="bg-white rounded-2xl shadow-2xl p-8 mb-8">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-blue-600 mb-2">
                        Sistem Pembayaran KKN
                    </h1>
                    <p class="text-gray-600 text-lg">
                        Kuliah Kerja Nyata Tahun 2025
                    </p>
                    <div class="mt-4 inline-block bg-blue-50 px-6 py-3 rounded-full">
                        <p class="text-blue-800 font-semibold">Biaya KKN: Rp 500.000</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Card Pendaftaran -->
                    <div class="border-2 border-blue-200 rounded-xl p-6 card-hover cursor-pointer"
                        onclick="showPage('register')">
                        <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-3 text-gray-800">Pendaftaran Baru</h2>
                        <p class="text-gray-600 mb-4">
                            Daftar sebagai peserta KKN dan dapatkan kode pembayaran
                        </p>
                        <div class="text-blue-600 font-medium flex items-center">
                            Daftar Sekarang
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </div>
                    </div>

                    <!-- Card Cek Status -->
                    <div class="border-2 border-green-200 rounded-xl p-6">
                        <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <h2 class="text-xl font-semibold mb-3 text-gray-800">Cek Status Pembayaran</h2>
                        <form onsubmit="checkStatus(event)" class="space-y-3">
                            <input type="text" id="nimInput" placeholder="Masukkan NIM Anda"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-green-500 focus:outline-none"
                                required>
                            <button type="submit"
                                class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 font-medium transition">
                                Cek Status
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Penting
                    </h3>
                    <ul class="space-y-2 text-gray-700">
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">•</span>
                            <span>Pembayaran dapat dilakukan melalui transfer bank atau e-wallet</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">•</span>
                            <span>Upload bukti pembayaran setelah melakukan transfer</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-blue-600 mr-2">•</span>
                            <span>Verifikasi pembayaran maksimal 2x24 jam</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Page -->
    <div id="registerPage" class="container mx-auto px-4 py-12 hidden">
        <div class="max-w-2xl mx-auto fade-in">
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <button onclick="showPage('home')" class="mb-6 text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                    Kembali
                </button>

                <h1 class="text-3xl font-bold mb-2 text-gray-800">Form Pendaftaran KKN</h1>
                <p class="text-gray-600 mb-6">Lengkapi data diri Anda dengan benar</p>

                <form onsubmit="submitRegister(event)" class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">NIM *</label>
                            <input type="text" id="nim" placeholder="2025010001"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Nama Lengkap *</label>
                            <input type="text" id="name" placeholder="Nama lengkap sesuai KTM"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                required>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Email *</label>
                            <input type="email" id="email" placeholder="email@example.com"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                required>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">No. Telepon *</label>
                            <input type="tel" id="phone" placeholder="08123456789"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Fakultas *</label>
                        <select id="faculty"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                            required>
                            <option value="">Pilih Fakultas</option>
                            <option value="Teknik">Fakultas Teknik</option>
                            <option value="Ekonomi">Fakultas Ekonomi dan Bisnis</option>
                            <option value="FISIP">Fakultas Ilmu Sosial dan Politik</option>
                            <option value="Hukum">Fakultas Hukum</option>
                            <option value="Kedokteran">Fakultas Kedokteran</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Program Studi *</label>
                        <input type="text" id="program" placeholder="Contoh: Teknik Informatika"
                            class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                            required>
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold text-lg transition">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Payment Page -->
    <div id="paymentPage" class="container mx-auto px-4 py-12 hidden">
        <div class="max-w-4xl mx-auto fade-in">
            <button onclick="showPage('home')" class="mb-6 text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Beranda
            </button>

            <!-- Success Message -->
            <div id="successMsg"
                class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 hidden">
                <p class="font-semibold">✓ Pendaftaran berhasil! Silakan lakukan pembayaran.</p>
            </div>

            <!-- Student Info -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-6">
                <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
                    <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Mahasiswa
                </h2>
                <div class="grid md:grid-cols-2 gap-4 text-gray-700">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">NIM</p>
                        <p class="font-semibold" id="displayNim">2025010001</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Nama Lengkap</p>
                        <p class="font-semibold" id="displayName">Ahmad Fauzi</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Email</p>
                        <p class="font-semibold" id="displayEmail">ahmad@email.com</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Telepon</p>
                        <p class="font-semibold" id="displayPhone">081234567890</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Fakultas</p>
                        <p class="font-semibold" id="displayFaculty">Teknik</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 mb-1">Program Studi</p>
                        <p class="font-semibold" id="displayProgram">Teknik Informatika</p>
                    </div>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Detail Pembayaran</h2>
                    <span class="px-4 py-2 bg-yellow-500 text-white rounded-full font-semibold" id="paymentStatus">
                        PENDING
                    </span>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded mb-6">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Kode Pembayaran</p>
                            <p class="font-bold text-lg text-blue-700">KKN-2025-001</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-1">Jumlah Pembayaran</p>
                            <p class="font-bold text-2xl text-blue-700">Rp 500.000</p>
                        </div>
                    </div>
                </div>

                <!-- Bank Info -->
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 p-6 rounded-xl mb-6">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                        Informasi Rekening
                    </h3>
                    <div class="space-y-3">
                        <div class="bg-white p-4 rounded-lg">
                            <p class="font-semibold text-blue-700">Bank BNI</p>
                            <p class="text-gray-700">1234567890 a.n. <strong>Universitas XYZ</strong></p>
                        </div>
                        <div class="bg-white p-4 rounded-lg">
                            <p class="font-semibold text-blue-700">Bank Mandiri</p>
                            <p class="text-gray-700">0987654321 a.n. <strong>Universitas XYZ</strong></p>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="border-t pt-6">
                    <h3 class="font-semibold text-gray-800 mb-4 text-lg">Upload Bukti Pembayaran</h3>
                    <form onsubmit="uploadProof(event)" class="space-y-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Metode Pembayaran *</label>
                            <select
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                required>
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="bank_transfer">Transfer Bank</option>
                                <option value="e_wallet">E-Wallet (GoPay, OVO, Dana)</option>
                                <option value="cash">Tunai (Kasir Kampus)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Bukti Pembayaran (JPG/PNG) *</label>
                            <input type="file" accept="image/*"
                                class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:border-blue-500 focus:outline-none"
                                onchange="previewImage(event)" required>
                            <p class="text-sm text-gray-500 mt-2">Maksimal ukuran file: 2MB</p>
                        </div>
                        <div id="imagePreview" class="hidden">
                            <p class="text-sm text-gray-600 mb-2">Preview:</p>
                            <img id="preview" class="max-w-md rounded-lg shadow-md" alt="Preview">
                        </div>
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-semibold transition">
                            Upload Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Page -->
    <div id="adminPage" class="container mx-auto px-4 py-12 hidden">
        <div class="max-w-7xl mx-auto fade-in">
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Dashboard Admin - Pembayaran KKN</h1>
                    <button onclick="showPage('home')" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                        Logout
                    </button>
                </div>

                <!-- Stats -->
                <div class="grid md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white p-6 rounded-xl">
                        <p class="text-sm mb-2 opacity-90">Total Mahasiswa</p>
                        <p class="text-3xl font-bold">45</p>
                    </div>
                    <div class="bg-gradient-to-br from-green-500 to-green-600 text-white p-6 rounded-xl">
                        <p class="text-sm mb-2 opacity-90">Terbayar</p>
                        <p class="text-3xl font-bold">32</p>
                    </div>
                    <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 text-white p-6 rounded-xl">
                        <p class="text-sm mb-2 opacity-90">Pending</p>
                        <p class="text-3xl font-bold">10</p>
                    </div>
                    <div class="bg-gradient-to-br from-red-500 to-red-600 text-white p-6 rounded-xl">
                        <p class="text-sm mb-2 opacity-90">Ditolak</p>
                        <p class="text-3xl font-bold">3</p>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Kode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">NIM</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Fakultas
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">KKN-2025-001</td>
                                <td class="px-6 py-4 text-sm">2025010001</td>
                                <td class="px-6 py-4 text-sm font-medium">Ahmad Fauzi</td>
                                <td class="px-6 py-4 text-sm">Teknik</td>
                                <td class="px-6 py-4 text-sm">Rp 500.000</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-yellow-500 text-white rounded-full text-xs font-semibold">
                                        PENDING
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex gap-2">
                                        <button onclick="viewProof()"
                                            class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                            Lihat
                                        </button>
                                        <button onclick="verifyPayment()"
                                            class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
                                            Verifikasi
                                        </button>
                                        <button onclick="rejectPayment()"
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                            Tolak
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">KKN-2025-002</td>
                                <td class="px-6 py-4 text-sm">2025010002</td>
                                <td class="px-6 py-4 text-sm font-medium">Siti Nurhaliza</td>
                                <td class="px-6 py-4 text-sm">Ekonomi</td>
                                <td class="px-6 py-4 text-sm">Rp 500.000</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-green-500 text-white rounded-full text-xs font-semibold">
                                        PAID
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <button class="bg-gray-300 text-gray-600 px-3 py-1 rounded cursor-not-allowed">
                                        Terverifikasi
                                    </button>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm">KKN-2025-003</td>
                                <td class="px-6 py-4 text-sm">2025010003</td>
                                <td class="px-6 py-4 text-sm font-medium">Budi Santoso</td>
                                <td class="px-6 py-4 text-sm">FISIP</td>
                                <td class="px-6 py-4 text-sm">Rp 500.000</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 bg-red-500 text-white rounded-full text-xs font-semibold">
                                        FAILED
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <button class="bg-gray-300 text-gray-600 px-3 py-1 rounded cursor-not-allowed">
                                        Ditolak
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPage(page) {
            document.getElementById('homePage').classList.add('hidden');
            document.getElementById('registerPage').classList.add('hidden');
            document.getElementById('paymentPage').classList.add('hidden');
            document.getElementById('adminPage').classList.add('hidden');

            document.getElementById(page + 'Page').classList.remove('hidden');
            window.scrollTo(0, 0);
        }

        function submitRegister(e) {
            e.preventDefault();

            const nim = document.getElementById('nim').value;
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const phone = document.getElementById('phone').value;
            const faculty = document.getElementById('faculty').value;

        }