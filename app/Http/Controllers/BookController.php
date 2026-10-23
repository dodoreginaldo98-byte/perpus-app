<?php
namespace App\Http\Controllers;
use App\Models\Book;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
class BookController extends Controller
{
 public function index(Request $request)
{
    $books = Book::when($request->search, function ($query, $search) {
            // Blok ini HANYA dijalankan jika $request->search tidak kosong.
            // where(...)->orWhere(...) berarti: cocok di judul ATAU di pengarang
            $query->where('judul', 'like', "%{$search}%")
                  ->orWhere('pengarang', 'like', "%{$search}%");
        })
        ->latest()
        ->paginate(10)
        // Menjaga kata kunci pencarian tetap terbawa saat pindah halaman paginasi
        ->withQueryString();

    return inertia('Books/Index', [
        'books' => $books,
        // Dikirim balik ke Vue agar kotak pencarian tetap terisi
        'search' => $request->search,
    ]);
}
 public function create()
 {
 return Inertia::render('Books/Create');
 }
 public function store(Request $request)
{
    $validated = $request->validate([
        'kode_buku' => 'required|unique:books,kode_buku',
        'judul'     => 'required|max:255',
        'pengarang' => 'required|max:255',
        'penerbit'  => 'nullable|max:255',
        'tahun'     => 'nullable|digits:4',
        'stok'      => 'required|integer|min:0',
    ], [
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
 return inertia('Books/Edit', [
 'book' => $book,
 ]);
 }
 public function update(Request $request, Book $book)
 {
  $validated = $request->validate([
        'kode_buku' => ['required', Rule::unique('books', 'kode_buku')->ignore($book->id)],
        'judul'     => 'required',
        'pengarang' => 'required',
        'stok'      => 'required|integer|min:0',
    ]);

    $book->update($validated);

    return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui');
 }
 public function destroy(Book $book)
 {
 $book->delete();
 return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus');
 }
}