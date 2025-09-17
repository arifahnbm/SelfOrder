<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralReview;
use App\Models\MenuReview;

class ReviewController extends Controller
{
    // Simpan review general (restoran)
    public function storeGeneral(Request $request)
    {
        $request->validate([
            'nama' => 'nullable|string|max:255',
            'komentar' => 'required|string',
        ]);

        GeneralReview::create($request->only('nama', 'komentar'));

        return back()->with('success', 'Terima kasih atas masukan Anda!');
    }

    // Simpan review menu
    public function storeMenu(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'nama' => 'nullable|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        MenuReview::create($request->only('menu_id', 'nama', 'rating', 'komentar'));

        return back()->with('success', 'Review menu berhasil dikirim!');
    }

    // Admin lihat semua review
    public function index()
    {
        $generalReviews = GeneralReview::latest()->get();
        $menuReviews = MenuReview::with('menu')->latest()->get();

        return view('admin.reviews.index', compact('generalReviews', 'menuReviews'));
    }
}

