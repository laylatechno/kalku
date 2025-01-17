<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\HasilHitung;
use App\Models\Slider;
use App\Models\User;
use App\Models\Video;
use App\Models\Visitor;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    // public function index(): Response
    // {
    //     dd('index');
    // }

    public function index()
    {
        $title = "Halaman Dashboard";
        $subtitle = "Menu Dashboard";
       
        $visits = Cache::remember('visits_cache', 6, function () {
            return Visitor::where('visit_time', '>=', Carbon::now()->subWeek())
                ->selectRaw('DATE(visit_time) as date, COUNT(*) as count')
                ->groupBy('date')
                ->orderBy('date')
                ->get();
        });

        $count_berita = Cache::remember('count_berita_cache', 6, function () {
            return Berita::all()->count();
        });

        $count_video = Cache::remember('count_video_cache', 6, function () {
            return Video::all()->count();
        });

        $count_user = Cache::remember('count_user_cache', 6, function () {
            return User::all()->count();
        });

        $count_slider = Cache::remember('count_slider_cache', 6, function () {
            return Slider::all()->count();
        });

        $count_anak_laki = Cache::remember('count_anak_laki_cache', 6, function () {
            return HasilHitung::where('jenis_kelamin', 'Laki-laki')->count();
        });
    
        $count_anak_perempuan = Cache::remember('count_anak_perempuan_cache', 6, function () {
            return HasilHitung::where('jenis_kelamin', 'Perempuan')->count();
        });

        $gender_data_anak = Cache::remember('gender_data_anak_cache', 6, function () use ($count_anak_laki, $count_anak_perempuan) {
            return [
                'Laki-laki' => $count_anak_laki,
                'Perempuan' => $count_anak_perempuan,
            ];
        });

        return view('back.dashboard',compact('title','subtitle','visits','count_berita','count_video','count_user','count_slider','gender_data_anak'));
    }

    public function create(): Response
    {
        dd('create');
    }

    public function store(Request $request): RedirectResponse
    {
        dd('store');
    }

    public function show(string $id): Response
    {
        dd('show');
    }

    public function edit(string $id): Response
    {
        dd('edit');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        dd('update');
    }

    public function destroy(string $id): RedirectResponse
    {
        dd('store');
    }
}