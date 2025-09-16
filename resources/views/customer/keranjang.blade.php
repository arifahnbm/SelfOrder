<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-blue-100" x-data="{ toast: '', showToast: false }">

    @include('customer.body.nav')

    <div class="container mx-auto mt-6 p-4 bg-white rounded-lg shadow-md">
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold mb-4">Keranjang Belanja</h1>
            <h1 class="text-2xl font-bold mb-4 text-blue-600">
                Total Rp. @php echo number_format($totalBayar, 0, ',', '.'); @endphp
            </h1>
        </div>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">#</th>
                    <th class="border border-gray-300 px-4 py-2">Nama Produk</th>
                    <th class="border border-gray-300 px-4 py-2">Harga</th>
                    <th class="border border-gray-300 px-4 py-2">Jumlah</th>
                    <th class="border border-gray-300 px-4 py-2">Subtotal</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keranjangs as $keranjang)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{ $keranjang->menu->nama }}
                            @if ($keranjang->ukuran)
                                <div class="text-xs text-gray-500">(Ukuran: {{ $keranjang->ukuran }})</div>
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            Rp. @php echo number_format($keranjang->harga_satuan, 0, ',', '.'); @endphp
                        </td>

                        {{-- QTY Buttons --}}
                        <td class="border border-gray-300 px-2 py-2 text-center">
                            <form action="{{ route('customer.keranjang.update', $keranjang->id) }}"
                                method="POST" class="inline-flex items-center"
                                x-data="{ jumlah: {{ $keranjang->jumlah }} }">
                                @csrf
                                @method('PUT')

                                <!-- Tombol - -->
                                <button type="submit" name="action" value="decrement"
                                    class="mx-1 px-3 py-1 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold rounded-l transition">
                                    −
                                </button>

                                <!-- Input jumlah (animated bounce) -->
                                <input type="number" name="jumlah" x-model="jumlah"
                                    class="w-13 text-center border-t border-b border-gray-300 focus:outline-none text-lg font-semibold transform transition-transform duration-150"
                                    x-effect="$el.classList.add('scale-110'); setTimeout(()=> $el.classList.remove('scale-110'),150)">

                                <!-- Tombol + -->
                                <button type="submit" name="action" value="increment"
                                    class="mx-1 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-r transition">
                                    +
                                </button>
                            </form>
                        </td>

                        <td class="border border-gray-300 px-4 py-2 text-center text-blue-600 font-semibold">
                            Rp. @php echo number_format($keranjang->total_harga, 0, ',', '.'); @endphp
                        </td>
                        <td class="border border-gray-300 px-4 py-2 text-center">
                            <form action="{{ route('customer.keranjang.delete', $keranjang->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="text-white bg-red-600 hover:bg-red-800 rounded-lg px-2 py-1">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Checkout -->
        <div class="mt-4">
            <form action="{{ route('customer.keranjang.checkout') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label for="nomor_meja"
                        class="block mb-2 text-sm font-medium text-gray-900">Nomor Meja</label>
                    <select name="nomor_meja" id="nomor_meja" required
                        class="block w-full p-3 border border-gray-300 rounded-lg bg-gray-50">
                        <option value="">Pilih Nomor Meja</option>
                        @foreach ($nomor_mejas as $meja)
                            <option value="{{ $meja->nomor }}"
                                {{ old('nomor_meja') == $meja->nomor ? 'selected' : '' }}>
                                Meja {{ $meja->nomor }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="w-20 text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-3">
                    Pesan
                </button>
            </form>
        </div>
    </div>

    <!-- Toast Notification -->
    <div x-show="showToast" x-transition.opacity.duration.300ms
        class="fixed bottom-5 right-5 bg-green-600 text-white px-5 py-3 rounded-lg shadow-lg z-50"
        x-text="toast" x-cloak></div>

    <script>
        // Jika session success/error, munculkan toast
        @if (session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                let app = document.querySelector('body');
                app.__x.$data.toast = "{{ session('success') }}";
                app.__x.$data.showToast = true;
                setTimeout(() => app.__x.$data.showToast = false, 3000);
            });
        @endif

        @if (session('error'))
            document.addEventListener('DOMContentLoaded', () => {
                let app = document.querySelector('body');
                app.__x.$data.toast = "{{ session('error') }}";
                app.__x.$data.showToast = true;
                setTimeout(() => app.__x.$data.showToast = false, 3000);
            });
        @endif
    </script>
</body>

</html>
