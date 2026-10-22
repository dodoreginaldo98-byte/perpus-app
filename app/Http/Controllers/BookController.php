<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
class BookController extends Controller
{
 public function index()
 {
     return Inertia::render('Books/Index', [
        'books' => Book::latest()->paginate(10),
    ]);
 }
 public function create()
 {
 return Inertia::render('Books/Create');
 }
 public function store(Request $request)
 {
 $validated = $request->validate([
 'kode_buku' => 'required|unique:books', // wajib diisi, tidak boleh sama dengan 
 'judul' => 'required|max:255',
 'pengarang' => 'required|max:255',
 'penerbit' => 'nullable|max:255', // boleh kosong
 'tahun' => 'nullable|digits:4', // jika diisi, harus 4 digit angka
 'stok' => 'required|integer|min:0',
 ]);
( [
        'stok.required' => 'Stok wajib diisi.',
        'stok.integer'  => 'Stok harus berupa angka bulat.',
        'stok.min'      => 'Stok tidak boleh bernilai negatif.',
    ]);
 Book::create($validated);
 return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan');
 }
 public function show(Book $book)
 {
 
 }
 public function edit(Book $book)
 {
 //
 }
 public function update(Request $request, Book $book)
 {
 //
 }
 public function destroy(Book $book)
 {
 //
 }
}