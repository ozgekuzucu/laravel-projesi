<?php

namespace App\Http\Controllers;

use App\Models\Kitap;
use App\Models\OduncKaydi;
use Illuminate\Http\Request;

/**
 * Hafta 9: Resource Controller - Ödünç işlemleri
 * php artisan make:controller OduncController --resource
 */
class OduncController extends Controller
{
    /**
     * index() - Tüm ödünç kayıtlarını listele
     * GET /odunc
     */
    public function index()
    {
        // Hafta 7: Model ile ilişkili kayıtları getirme (with = eager loading)
        $kayitlar = OduncKaydi::with('kitap')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15);

        $oduncSayisi = OduncKaydi::where('durum', 'oduncte')->count();
        $iadeSayisi  = OduncKaydi::where('durum', 'iade_edildi')->count();

        return view('odunc.index', compact('kayitlar', 'oduncSayisi', 'iadeSayisi'));
    }

    /**
     * create() - Yeni ödünç verme formu
     * GET /odunc/create
     */
    public function create()
    {
        // Sadece stoku olan kitaplar
        $kitaplar = Kitap::where('stok', '>', 0)->orderBy('baslik')->get();
        return view('odunc.create', compact('kitaplar'));
    }

    /**
     * store() - Ödünç kaydı oluştur
     * POST /odunc
     * Hafta 8: Validation + Hafta 10: Session
     */
    public function store(Request $request)
    {
        // Hafta 8: Validation
        $validatedData = $request->validate([
            'kitap_id'     => 'required|exists:kitaplar,id',
            'uye_adi'      => 'required|string|min:3|max:100',
            'uye_email'    => 'required|email|max:255',
            'odunc_tarihi' => 'required|date',
        ], [
            'kitap_id.required'     => 'Kitap seçimi zorunludur.',
            'kitap_id.exists'       => 'Seçilen kitap bulunamadı.',
            'uye_adi.required'      => 'Üye adı zorunludur.',
            'uye_adi.min'           => 'Üye adı en az 3 karakter olmalıdır.',
            'uye_email.required'    => 'E-posta adresi zorunludur.',
            'uye_email.email'       => 'Geçerli bir e-posta adresi giriniz.',
            'odunc_tarihi.required' => 'Ödünç tarihi zorunludur.',
        ]);

        // Kitabın stokunu 1 azalt
        $kitap = Kitap::findOrFail($validatedData['kitap_id']);
        if ($kitap->stok <= 0) {
            return back()->withErrors(['kitap_id' => 'Bu kitabın stoğu tükenmüştür.'])->withInput();
        }
        $kitap->decrement('stok');

        // Kayıt oluştur
        OduncKaydi::create($validatedData);

        // Hafta 10: Session flash
        session()->flash('basari', $kitap->baslik . ' kitabı ' . $validatedData['uye_adi'] . ' adına ödünç verildi.');

        return redirect()->route('odunc.index');
    }

    /**
     * show() - Ödünç kaydı detayı
     * GET /odunc/{id}
     */
    public function show(string $id)
    {
        $kayit = OduncKaydi::with('kitap')->findOrFail($id);
        return view('odunc.show', compact('kayit'));
    }

    /**
     * edit() - Düzenleme formu (iade işlemi için)
     * GET /odunc/{id}/edit
     */
    public function edit(string $id)
    {
        $kayit = OduncKaydi::with('kitap')->findOrFail($id);
        return view('odunc.edit', compact('kayit'));
    }

    /**
     * update() - İade işlemi
     * PUT /odunc/{id}
     */
    public function update(Request $request, string $id)
    {
        $kayit = OduncKaydi::with('kitap')->findOrFail($id);

        $validatedData = $request->validate([
            'iade_tarihi' => 'required|date|after_or_equal:' . $kayit->odunc_tarihi->format('Y-m-d'),
            'durum'       => 'required|in:oduncte,iade_edildi',
        ], [
            'iade_tarihi.required'         => 'İade tarihi zorunludur.',
            'iade_tarihi.after_or_equal'   => 'İade tarihi, ödünç tarihinden önce olamaz.',
            'durum.required'               => 'Durum seçimi zorunludur.',
        ]);

        // İade ediliyorsa stoğu artır
        if ($validatedData['durum'] === 'iade_edildi' && $kayit->durum === 'oduncte') {
            $kayit->kitap->increment('stok');
        }

        $kayit->update($validatedData);

        session()->flash('basari', $kayit->kitap->baslik . ' iade edildi, stok güncellendi.');

        return redirect()->route('odunc.index');
    }

    /**
     * destroy() - Kayıt sil
     * DELETE /odunc/{id}
     */
    public function destroy(string $id)
    {
        $kayit = OduncKaydi::findOrFail($id);
        $kayit->delete();

        session()->flash('uyari', 'Ödünç kaydı silindi.');

        return redirect()->route('odunc.index');
    }
}
