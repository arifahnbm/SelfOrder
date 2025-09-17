<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $menu->nama }} | Detail Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Toast Animation */
        .toast {
            animation: slideIn 0.5s, fadeOut 0.5s 3s forwards;
        }

        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            from { opacity: 1; }
            to { opacity: 0; transform: translateX(100%); }
        }

        /* Qty bounce effect */
        .bounce {
            animation: bounce 0.3s;
        }

        @keyframes bounce {
            0%   { transform: scale(1); }
            30%  { transform: scale(1.2); }
            50%  { transform: scale(0.95); }
            100% { transform: scale(1); }
        }

        .flash {
            animation: flash 0.4s;
        }

        @keyframes flash {
            0%   { background-color: #e0f2fe; }
            100% { background-color: transparent; }
        }

        /* Footer animation */
        .footer-anim {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                transform: translateY(100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-blue-100 ">

    <!-- Navbar -->
    @include('customer.body.nav')

    <div class="relative min-h-screen bg-blue-100 pb-28"> 
        <!-- padding bawah untuk ruang footer -->

        <!-- Card Konten -->
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-6 mt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Gambar -->
                <div>
                    <img src="{{ asset($menu->gambar) }}" 
                         alt="{{ $menu->nama }}" 
                         class="w-full h-96 object-cover rounded-xl shadow-md transition duration-500 hover:scale-105">
                </div>

                <!-- Detail -->
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $menu->nama }}</h1>
                    <p class="text-blue-600 font-medium mt-1">
                        {{ $menu->kategori->nama ?? 'Tanpa Kategori' }}
                    </p>

                    <p class="mt-4 text-gray-600 leading-relaxed">
                        {{ $menu->deskripsi }}
                    </p>
                    <button onclick="showPopUpAdd()" class="bg-blue-600 text-white border mt-8  px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                        Beri Rating & Review
                    </button>
                </div>
            </div>
        </div>

        <div id="popUpAdd" class="hidden fixed inset-0 z-50 flex items-center justify-center">
            <!-- Overlay -->
            <div class="absolute inset-0 bg-black bg-opacity-50" onclick="hidePopUpAdd()"></div>

            <!-- Modal content -->
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md z-10 p-6">
                <!-- Close button -->
                <button onclick="hidePopUpAdd()"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 dark:hover:text-white text-xl font-bold">
                    &times;
                </button>

                <h1 class="text-xl font-bold text-blue-900 dark:text-white mb-4">Beri Masukan untuk Menu</h1>
                <!-- ================= FORM REVIEW ================= -->
                <form action="{{ route('review.menu.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                    <input type="text" name="nama" placeholder="Nama (opsional)" class="w-full border border-gray-300 rounded-lg p-2">

                    <!-- Rating -->
                    <div>
                        <label class="block text-sm font-bold text-gray-900 dark:text-gray-100 mb-2">Beri Rating</label>
                        <div class="flex space-x-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <label>
                                    <input type="radio" name="rating" value="{{ $i }}" class="hidden peer" required>
                                    <svg class="w-8 h-8 cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-500 transition"
                                        fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 
                                                1 0 00.95.69h3.462c.969 0 1.371 1.24.588 
                                                1.81l-2.8 2.034a1 1 0 00-.364 
                                                1.118l1.07 3.292c.3.921-.755 
                                                1.688-1.54 1.118l-2.8-2.034a1 
                                                1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 
                                                1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 
                                                1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </label>
                            @endfor
                        </div>
                    </div>

                    <!-- Komentar -->
                    <div>
                        <label for="komentar" class="block text-sm font-bold text-gray-900 dark:text-gray-100 mb-2">Komentar</label>
                        <textarea name="komentar" id="komentar" rows="3" 
                                class="w-full p-2 border rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                placeholder="Tulis komentar Anda tentang menu ini..."></textarea>
                    </div>

                    <!-- Tombol submit -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                            Kirim Review
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Footer Mengambang -->
        <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg p-4 footer-anim">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                
                <!-- Harga -->
                <span class="text-2xl md:text-3xl font-bold text-blue-600">
                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                </span>

                <!-- Form keranjang -->
                @if(strtolower($menu->stok) === 'tersedia')
                <form action="{{ route('customer.keranjang.add', $menu->id) }}" method="POST" class="flex items-center space-x-3">
                    @csrf
                    <input type="hidden" name="menu_id" value="{{ $menu->id }}">

                    <!-- Tombol QTY -->
                    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                        <button type="button" onclick="decrementQty()" 
                            class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">-</button>
                        
                        <input id="quantity" type="number" name="quantity" value="1" min="1"
                            class="w-12 text-center border-0 focus:ring-0 focus:outline-none text-gray-900">
                        
                        <button type="button" onclick="incrementQty()" 
                            class="px-3 py-2 text-lg font-bold text-gray-600 hover:bg-gray-200 transition">+</button>
                    </div>

                    <!-- Tombol Tambah -->
                    <button type="submit"
                        class="flex items-center bg-blue-600 text-white font-medium rounded-lg px-5 py-2.5 
                               hover:bg-blue-700 shadow-md transform transition hover:scale-105 active:scale-95">
                        Tambah
                    </button>
                </form>
                @else
                    <button
                        class="text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-sm px-5 py-2.5"
                        disabled>
                        Habis
                    </button>
                @endif
            </div>
        </div>

    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-5 right-5 space-y-2 z-50"></div>

    <!-- Script QTY & Toast -->
    <script>
        function incrementQty() {
            let qty = document.getElementById('quantity');
            qty.value = parseInt(qty.value) + 1;
            qty.classList.add("flash");
            qty.previousElementSibling.classList.add("bounce");
            qty.nextElementSibling.classList.add("bounce");
            setTimeout(() => {
                qty.classList.remove("flash");
                qty.previousElementSibling.classList.remove("bounce");
                qty.nextElementSibling.classList.remove("bounce");
            }, 400);
        }

        function decrementQty() {
            let qty = document.getElementById('quantity');
            if (parseInt(qty.value) > 1) {
                qty.value = parseInt(qty.value) - 1;
                qty.classList.add("flash");
                qty.previousElementSibling.classList.add("bounce");
                qty.nextElementSibling.classList.add("bounce");
                setTimeout(() => {
                    qty.classList.remove("flash");
                    qty.previousElementSibling.classList.remove("bounce");
                    qty.nextElementSibling.classList.remove("bounce");
                }, 400);
            }
        }

        // fungsi toast
        function showToast(message) {
            const container = document.getElementById("toast-container");
            const toast = document.createElement("div");
            toast.className = "toast bg-blue-600 text-white px-4 py-2 rounded-lg shadow-md";
            toast.innerText = message;
            container.appendChild(toast);

            // auto remove setelah animasi selesai
            setTimeout(() => {
                toast.remove();
            }, 4000);
        }

        // cek apakah ada session flash dari Laravel
        @if(session('success'))
            showToast("{{ session('success') }}");
        @endif
    </script>

    <script>
        function showPopUpAdd() {
            document.getElementById('popUpAdd').classList.remove('hidden');
        }

        function hidePopUpAdd() {
            document.getElementById('popUpAdd').classList.add('hidden');
        }
    </script>
</body>
</html>
