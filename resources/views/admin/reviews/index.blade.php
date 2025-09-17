<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <title>Admin Review dan Masukan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/js/code.js') }}"></script>
</head>

<body x-data="{ 'darkMode': false, 'sidebarToggle': false}" x-init="
         darkMode = JSON.parse(localStorage.getItem('darkMode'));
         $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
    :class="{'dark bg-gray-900': darkMode === true}">

    @include('admin.body.sidebar')
    @include('admin.body.header')

    <div class="p-4">
        <div class=" overflow-x-auto  shadow-md sm:rounded-lg">
            <h2 class="text-center mb-5 font-bold dark:text-white">Review dan Masukan</h2>
            <!-- Review General -->
            <h3 class="text-xl font-semibold mb-2">Masukan Restoran</h3>
            <table class="w-full border mb-6">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Komentar</th>
                        <th class="border p-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($generalReviews as $review)
                        <tr>
                            <td class="border p-2">{{ $review->nama ?? 'Anonim' }}</td>
                            <td class="border p-2">{{ $review->komentar }}</td>
                            <td class="border p-2">{{ $review->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center p-4 text-gray-500">Belum ada masukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Review Menu -->
            <h3 class="text-xl font-semibold mb-2">Review Menu</h3>
            <table class="w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2">Menu</th>
                        <th class="border p-2">Nama</th>
                        <th class="border p-2">Rating</th>
                        <th class="border p-2">Komentar</th>
                        <th class="border p-2">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($menuReviews as $review)
                        <tr>
                            <td class="border p-2">{{ $review->menu->nama }}</td>
                            <td class="border p-2">{{ $review->nama ?? 'Anonim' }}</td>
                            <td class="border p-2">⭐ {{ $review->rating }}</td>
                            <td class="border p-2">{{ $review->komentar }}</td>
                            <td class="border p-2">{{ $review->created_at->format('d M Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">Belum ada review menu</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    




</body>

</html>