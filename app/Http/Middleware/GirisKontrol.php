<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Hafta 3: Middleware (arakatman)
 * php artisan make:middleware GirisKontrol
 *
 * Bu middleware, kullanıcının giriş yapıp yapmadığını kontrol eder.
 * Giriş yapılmamışsa login sayfasına yönlendirir.
 *
 * Nasıl çalışır:
 * 1. Kullanıcı bir sayfaya istek gönderir
 * 2. İstek önce bu middleware'den geçer
 * 3. Session'da 'kullanici' varsa → controller'a devam
 * 4. Yoksa → login sayfasına yönlendir
 */
class GirisKontrol
{
    public function handle(Request $request, Closure $next): Response
    {
        // Hafta 10: Session kontrolü - giriş yapılmış mı?
        if (!session()->has('kullanici')) {
            // Hafta 10: Flash mesaj
            session()->flash('uyari', 'Bu sayfaya erişmek için giriş yapmalısınız.');
            return redirect()->route('login');
        }

        return $next($request);
    }
}
