<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePosAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && in_array($user->role, [User::ROLE_KASIR, User::ROLE_ADMIN], true)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak. Halaman POS hanya untuk kasir dan admin.');
    }
}
