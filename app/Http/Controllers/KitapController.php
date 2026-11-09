<?php

namespace App\Http\Controllers;

use App\Models\Kitap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * Hafta 9: Resource Controller
 * php artisan make:controller KitapController --resource
 *
 * Bu controller, kitaplar için 7 temel CRUD metodunu içerir:
 * index, create, store, show, edit, update, destroy
 */
class KitapController extends Controller
{
    /**
     * index() - Tüm kitapları listele
     * GET /kitaplar
     * Hafta 9: Resource Controller index metodu
     * Hafta 10: Session kullanımı (flash mesaj gösterimi)
     */
    public function index(Request $request)
    {
        // Arama ve filtreleme
        $query = Kitap::query();

        if ($request->filled('ara')) {
            $ara = $request->input('ara');
            $query->where('baslik', 'like', "%$ara%")
                  ->orWhere('yazar', 'like', "%$ara%")
                  ->orWhere('isbn', 'like', "%$ara%");
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->input('kategori'));
        }

        $kitaplar = $query->orderBy('created_at', 'desc')->paginate(10);
        $kategoriler = Kitap::select('kategori')->distinct()->pluck('kategori');

        return view('kitaplar.index', compact('kitaplar', 'kategoriler'));
    }

    /**
     * create() - Yeni kitap ekleme formunu göster
     * GET /kitaplar/create
     */
    public function create()
    {
        $kategoriler = ['Roman', 'Bilim', 'Tarih', 'Felsefe', 'Teknoloji', 'Çocuk', 'Diğer'];
        return view('kitaplar.create', compact('kategoriler'));
    }

    /**
     * store() - Yeni kitabı veritabanına kaydet
     * POST /kitaplar
     * Hafta 8: Validation işlemleri
     * Hafta 8: Resim dosyası yükleme
     * Hafta 10: Session flash mesaj
     */
    public function store(Request $request)
    {
        // Hafta 8: Validation - Form doğrulama kuralları
        $validatedData = $request->validate([
            'baslik'     => 'required|string|min:2|max:255',
            'yazar'      => 'required|string|min:2|max:255',
            'isbn'       => 'required|string|unique:kitaplar,isbn',
            'kategori'   => 'required|string',
            'yayin_yili' => 'required|integer|min:1000|max:' . date('Y'),
            'stok'       => 'required|integer|min:0',
            'aciklama'   => 'nullable|string|max:1000',
            'kapak_resmi'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            // Hafta 8: Türkçe hata mesajları
            'baslik.required'     => 'Kitap başlığı zorunludur.',
            'baslik.min'          => 'Başlık en az 2 karakter olmalıdır.',
            'yazar.required'      => 'Yazar adı zorunludur.',
            'isbn.required'       => 'ISBN numarası zorunludur.',
            'isbn.unique'         => 'Bu ISBN numarası zaten kayıtlı.',
            'kategori.required'   => 'Kategori seçimi zorunludur.',
            'yayin_yili.required' => 'Yayın yılı zorunludur.',
            'yayin_yili.min'      => 'Geçerli bir yayın yılı giriniz.',
            'stok.required'       => 'Stok adedi zorunludur.',
            'stok.min'            => 'Stok negatif olamaz.',
            'kapak_resmi.image'   => 'Dosya bir resim olmalıdır.',
            'kapak_resmi.max'     => 'Resim boyutu en fazla 2MB olabilir.',
        ]);

        // Hafta 8: Resim dosyası yükleme
        if ($request->hasFile('kapak_resmi')) {
            $dosya = $request->file('kapak_resmi');
            $dosyaAdi = time() . '_' . $dosya->getClientOriginalName();
            $dosya->move(public_path('uploads/kapaklar'), $dosyaAdi);
            $validatedData['kapak_resmi'] = $dosyaAdi;
        }

        // Hafta 7: Model ile veritabanına kayıt (create)
        Kitap::create($validatedData);

        // Hafta 10: Session flash mesajı - başarılı kayıt bildirimi
        session()->flash('basari', '"' . $validatedData['baslik'] . '" başarıyla eklendi!');

        return redirect()->route('kitaplar.index');
    }

    /**
     * show() - Tek bir kitabı göster
     * GET /kitaplar/{id}
     */
    public function show(string $id)
    {
        // Hafta 7: Model ile veritabanından kayıt getirme
        $kitap = Kitap::with('oduncKayitlari')->findOrFail($id);
        return view('kitaplar.show', compact('kitap'));
    }

    /**
     * edit() - Güncelleme formunu göster
     * GET /kitaplar/{id}/edit
     */
    public function edit(string $id)
    {
        $kitap = Kitap::findOrFail($id);
        $kategoriler = ['Roman', 'Bilim', 'Tarih', 'Felsefe', 'Teknoloji', 'Çocuk', 'Diğer'];
        return view('kitaplar.edit', compact('kitap', 'kategoriler'));
    }

    /**
     * update() - Kitap bilgilerini güncelle
     * PUT/PATCH /kitaplar/{id}
     * Hafta 8: Validation + Hafta 7: Model update
     */
    public function update(Request $request, string $id)
    {
        $kitap = Kitap::findOrFail($id);

        // Hafta 8: Validation - ISBN unique ama kendi kaydını hariç tut
        $validatedData = $request->validate([
            'baslik'     => 'required|string|min:2|max:255',
            'yazar'      => 'required|string|min:2|max:255',
            'isbn'       => 'required|string|unique:kitaplar,isbn,' . $id,
            'kategori'   => 'required|string',
            'yayin_yili' => 'required|integer|min:1000|max:' . date('Y'),
            'stok'       => 'required|integer|min:0',
            'aciklama'   => 'nullable|string|max:1000',
            'kapak_resmi'=> 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'baslik.required'   => 'Kitap başlığı zorunludur.',
            'yazar.required'    => 'Yazar adı zorunludur.',
            'isbn.required'     => 'ISBN numarası zorunludur.',
            'isbn.unique'       => 'Bu ISBN numarası başka bir kitapta kullanılıyor.',
            'kategori.required' => 'Kategori seçimi zorunludur.',
            'yayin_yili.required' => 'Yayın yılı zorunludur.',
            'stok.min'          => 'Stok negatif olamaz.',
        ]);

        // Yeni resim yüklendiyse eski resmi sil ve yenisini kaydet
        if ($request->hasFile('kapak_resmi')) {
            if ($kitap->kapak_resmi) {
                $eskiDosya = public_path('uploads/kapaklar/' . $kitap->kapak_resmi);
                if (file_exists($eskiDosya)) {
                    unlink($eskiDosya);
                }
            }
            $dosya = $request->file('kapak_resmi');
            $dosyaAdi = time() . '_' . $dosya->getClientOriginalName();
            $dosya->move(public_path('uploads/kapaklar'), $dosyaAdi);
            $validatedData['kapak_resmi'] = $dosyaAdi;
        }

        // Hafta 7: Model ile güncelleme (update)
        $kitap->update($validatedData);

        // Hafta 10: Session flash mesajı
        session()->flash('basari', '"' . $kitap->baslik . '" başarıyla güncellendi!');

        return redirect()->route('kitaplar.index');
    }

    /**
     * destroy() - Kitabı sil
     * DELETE /kitaplar/{id}
     * Hafta 7: Model ile silme (delete)
     */
    public function destroy(string $id)
    {
        $kitap = Kitap::findOrFail($id);
        $baslik = $kitap->baslik;

        // Resim varsa sil
        if ($kitap->kapak_resmi) {
            $dosya = public_path('uploads/kapaklar/' . $kitap->kapak_resmi);
            if (file_exists($dosya)) {
                unlink($dosya);
            }
        }

        // Hafta 7: Model ile silme
        $kitap->delete();

        // Hafta 10: Session flash mesajı
        session()->flash('uyari', '"' . $baslik . '" silindi.');

        return redirect()->route('kitaplar.index');
    }
}
