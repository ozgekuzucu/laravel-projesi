<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Hafta 10: Session (oturum) yönetimi
 * Hafta 8: Validation
 * Bu controller basit oturum açma/kapama işlemlerini yönetir.
 * (Laravel Auth paketi kullanılmadan, Session ile manuel yapılmıştır)
 */
class AuthController extends Controller
{
    // Giriş sayfasını göster
    public function loginForm()
    {
        // Zaten giriş yapılmışsa anasayfaya yönlendir
        if (session()->has('kullanici')) {
            return redirect()->route('kitaplar.index');
        }
        return view('auth.login');
    }

    /**
     * Giriş işlemi
     * Hafta 8: Validation - form doğrulama
     * Hafta 10: Session - oturum yönetimi
     */
    public function login(Request $request)
    {
        // Hafta 8: Validation
        $request->validate([
            'kullanici_adi' => 'required|string',
            'sifre'         => 'required|string|min:4',
        ], [
            'kullanici_adi.required' => 'Kullanıcı adı zorunludur.',
            'sifre.required'         => 'Şifre zorunludur.',
            'sifre.min'              => 'Şifre en az 4 karakter olmalıdır.',
        ]);

        // Basit kimlik doğrulama (gerçek projede veritabanından kontrol edilir)
        $kullanicilar = [
            'admin' => ['sifre' => 'admin123', 'rol' => 'admin', 'ad' => 'Kütüphaneci'],
            'user'  => ['sifre' => '1234', 'rol' => 'uye', 'ad' => 'Misafir Okuyucu'],
        ];

        $kullaniciAdi = $request->input('kullanici_adi');
        $sifre = $request->input('sifre');

        if (isset($kullanicilar[$kullaniciAdi]) && $kullanicilar[$kullaniciAdi]['sifre'] === $sifre) {
            // Hafta 10: Session'a kullanıcı bilgisi yaz
            session()->put('kullanici', [
                'adi'         => $kullanicilar[$kullaniciAdi]['ad'],
                'kullanici_adi' => $kullaniciAdi,
                'rol'         => $kullanicilar[$kullaniciAdi]['rol'],
            ]);

            // Hafta 10: Flash mesaj
            session()->flash('basari', 'Hoş geldiniz, ' . $kullanicilar[$kullaniciAdi]['ad'] . '!');

            return redirect()->route('kitaplar.index');
        }

        // Hatalı giriş
        return back()->withErrors([
            'kullanici_adi' => 'Kullanıcı adı veya şifre hatalı.',
        ])->withInput($request->only('kullanici_adi'));
    }

    /**
     * Çıkış işlemi
     * Hafta 10: Session flush - tüm session verilerini temizle
     */
    public function logout()
    {
        $ad = session('kullanici.adi', 'Kullanıcı');

        // Hafta 10: Session'ı tamamen temizle
        session()->flush();

        // Hafta 10: Flash mesaj (yeni session'da)
        session()->flash('bilgi', $ad . ' çıkış yaptı. Görüşmek üzere!');

        return redirect()->route('login');
    }
}
