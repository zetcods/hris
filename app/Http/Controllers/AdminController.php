<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User; 
use App\Models\Karyawan;
use App\Models\Divisi; 
use App\Models\Absensi;
use App\Models\Penggajian;
use Carbon\Carbon;
use Illuminate\Support\Str; 
use App\Http\Controllers\Controller; // Pastikan ini di-import

class AdminController extends Controller
{
    // HAPUS function __construct() di sini!

    // ==========================================\
    // DASHBOARD INDEX
    // ==========================================
    public function index()
    {
        $totalKaryawan = Karyawan::count();
        $totalDivisi = Divisi::count();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalAbsensiBulanIni = Absensi::whereBetween('tanggal', [$startOfMonth, $endOfMonth])->count();
        $listDivisi = Divisi::all();
        $karyawanPerDivisi = Divisi::withCount('karyawan')->get();
        
        $absensiStat = Absensi::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('tanggal', [$startOfMonth, $endOfMonth])
            ->groupBy('status')
            ->get();
            
        $totalGaji = Karyawan::sum('gaji');
        
        $user = Auth::guard('web')->check() ? Auth::guard('web')->user() : Auth::guard('karyawan')->user();
        $userName = $user->name ?? $user->nama ?? 'Admin/HRD';

        return view('admin.dashboard', compact(
            'totalKaryawan',
            'totalDivisi',
            'listDivisi',
            'totalAbsensiBulanIni',
            'karyawanPerDivisi',
            'absensiStat',
            'totalGaji',
            'userName'
        ));
    }


    // ==========================================\
    // ADMIN PROFILE & UPDATE LOGIC
    // ==========================================
    public function profile()
    {
        if (Auth::guard('karyawan')->check()) {
            $user = Auth::guard('karyawan')->user();
            $user->load('divisi');
            return view('admin.profile.hrd', compact('user'));
        }

        $user = Auth::guard('web')->user();
        return view('admin.profile.admin', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $guard = Auth::guard('web')->check() ? 'web' : 'karyawan';
        $user = Auth::guard($guard)->user();
        $model = $guard === 'web' ? User::class : Karyawan::class;
        $table = $guard === 'web' ? 'users' : 'karyawan';
        
        $request->validate([
            'name' => 'required|string|max:255', 
            'email' => 'required|email|unique:'.$table.',email,'.$user->id, 
        ]);
        
        $nameField = $guard === 'web' ? 'name' : 'nama';

        $model::where('id', $user->id)->update([
            $nameField => $request->name,
            'email' => $request->email,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $guard = Auth::guard('web')->check() ? 'web' : 'karyawan';
        $user = Auth::guard($guard)->user();
        $model = $guard === 'web' ? User::class : Karyawan::class;
        
        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('Password lama tidak cocok.');
                }
            }],
            'password' => 'required|min:6|confirmed',
        ]);

        $model::where('id', $user->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password berhasil diubah!');
    }
}