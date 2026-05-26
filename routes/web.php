<?php

use App\Exports\ProductTemplateExport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\Kasir\TransactionController;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('kasir.dashboard');
    }

    return view('home');
})->name('home');

Route::get('/akses', function () {
    if (Auth::check()) {
        return redirect()->route('kasir.dashboard');
    }

    return view('auth.method');
})->name('access');

Route::middleware('auth')->get('/admin/products/template', function () {
    return Excel::download(new ProductTemplateExport(), 'template-produk.xlsx');
})->name('products.template');

// Login
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('kasir.dashboard');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

// Register
Route::get('/register', function () {
    if (Auth::check()) {
        return redirect()->route('kasir.dashboard');
    }
    return view('auth.register');
})->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended('/admin');
})->name('admin.login.store');

Route::post('/finance/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    if (! Auth::attempt($credentials, $request->boolean('remember'))) {
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    $request->session()->regenerate();

    return redirect()->intended('/finance');
})->name('finance.login.store');

Route::middleware('auth')->get('/kasir', function () {
    $categories = Category::where('is_active', true)->get();
    $products = Product::where('is_available', true)->get();
    $transactionCount = Transaction::where('status', 'paid')
        ->whereDate('paid_at', now()->toDateString())
        ->count();
    $totalSales = Transaction::where('status', 'paid')
        ->whereDate('paid_at', now()->toDateString())
        ->sum('total');

    return view('kasir.dashboard', compact('categories', 'products', 'transactionCount', 'totalSales'));
})->name('kasir.dashboard');

Route::middleware('auth')->prefix('kasir')->name('kasir.')->group(function () {
    Route::post('/orders/paid', [TransactionController::class, 'storePaidOrder'])->name('orders.paid');
    Route::post('/vouchers/validate', [TransactionController::class, 'validateVoucher'])->name('vouchers.validate');
    Route::get('/histori/data', [TransactionController::class, 'indexHistory'])->name('histori.data');
    Route::get('/histori/{id}/data', [TransactionController::class, 'showHistory'])->name('histori.show');
    Route::get('/transfer-proofs/{filename}', function (string $filename) {
        $filename = basename($filename);
        $path = 'transfer-proofs/' . $filename;

        abort_unless(Storage::disk('public')->exists($path), 404);

        $full = storage_path('app/public/' . $path);
        $mime = Storage::disk('public')->mimeType($path) ?? 'application/octet-stream';

        // Serve inline so browser opens in a new tab instead of forcing download
        return response()->file($full, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    })->where('filename', '[A-Za-z0-9._-]+')->name('transfer-proofs.show');
});

Route::get('/nota/{order_code}', [TransactionController::class, 'showNota'])->name('kasir.nota.publik');

Route::get('/qr-code', function (Illuminate\Http\Request $request) {
    $text = $request->get('text', 'https://perpus-ums.id');
    $options = new \chillerlan\QRCode\QROptions([
        'version'     => 5,
        'outputType'  => \chillerlan\QRCode\QRCode::OUTPUT_MARKUP_SVG,
        'eccLevel'    => \chillerlan\QRCode\QRCode::ECC_L,
        'imageBase64' => false,
    ]);
    return response((new \chillerlan\QRCode\QRCode($options))->render($text))
        ->header('Content-Type', 'image/svg+xml');
})->name('qr-code');

// Logout
Route::match(['post', 'get'], '/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Dashboard
Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('kasir.dashboard');
})->name('dashboard');

Route::middleware('auth')->get('/kasir/order', function (Request $request) {
    $categories = Category::where('is_active', true)->get();
    
    // filter produk kategori
    $query = Product::where('is_available', true);
    
    if ($request->has('category') && $request->category != '') {
        $query->where('category_id', $request->category);
    }
    
    // filter pake nama
    if ($request->has('search') && $request->search != '') {
        $query->where('name', 'like', '%' . $request->search . '%');
    }
    
    $products = $query->get();

    return view('kasir.order', compact('categories', 'products'));
})->name('kasir.order');

Route::middleware('auth')->get('/kasir/split-bill', function () {
    return view('kasir.split-bill');
})->name('kasir.split-bill');

Route::middleware('auth')->get('/process/payment', function () {
    return view('process.payment');
})->name('kasir.payment');

Route::middleware('auth')->get('/process/payment-success', function () {
    return view('process.payment-success');
})->name('kasir.payment-success');

Route::middleware('auth')->get('/process/receipt', function () {
    return view('process.receipt');
})->name('kasir.receipt');

Route::middleware('auth')->get('/process/receipt-qr', function () {
    return view('process.receipt-qr');
})->name('kasir.receipt-qr');

Route::middleware('auth')->get('/kasir/histori', function () {
    return view('kasir.histori');
})->name('kasir.histori');

Route::middleware('auth')->get('/kasir/histori/{id}', function (string $id) {
    return view('kasir.detail-histori', [
        'orderId' => $id,
    ]);
})->where('id', '[^/]+')->name('kasir.histori.detail');

Route::middleware('auth')->get('/kasir/stok', function () {
    $categories = \App\Models\Category::all();
    $products = \App\Models\Product::with('category')->get();
    
    return view('kasir.stok', compact('categories', 'products'));
})->name('kasir.stok');

Route::middleware('auth')->post('/kasir/stok/{product}/toggle', function (\App\Models\Product $product) {
    $product->is_available = !$product->is_available;
    $product->save();
    
    return response()->json([
        'success' => true, 
        'is_available' => $product->is_available
    ]);
})->name('kasir.stok.toggle');


Route::middleware('auth')->get('/kasir/profile', function () {
    return view('components.profile-page');
})->name('kasir.profile');

Route::get('/doc', function () {
    return view('doc');
})->name('doc');
