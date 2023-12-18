<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $months = [
            '01' => 'Jan',
            '02' => 'Feb',
            '03' => 'Mar',
            '04' => 'Apr',
            '05' => 'Mei',
            '06' => 'Jun',
            '07' => 'Jul',
            '08' => 'Ags',
            '09' => 'Sep',
            '10' => 'Okt',
            '11' => 'Nov',
            '12' => 'Des',
        ];

        $resources = [];

        $baseUrl = 'https://tes-web.landa.id/intermediate';
        $transaksiUrl = $baseUrl . '/transaksi';
        $menuUrl = $baseUrl . '/menu';

        $responseMenus = Http::get($menuUrl);
        $menus = collect($responseMenus->json());

        $menusMap = [];
        foreach ($menus as  $menu) {
            $menusMap[$menu['menu']] = [
                'category' => $menu['kategori'],
                'name' => $menu['menu'],
            ];
        }

        if ($request->filled('tahun')) {
            $responseTransaksi = Http::get($transaksiUrl, [
                'tahun' => $request->tahun
            ]);

            $transaksi = collect($responseTransaksi->json())->groupBy('menu');

            $grandTotal = [
                'monthly' => [],
                'total' => 0,
            ];

            foreach ($months as $month) {
                $grandTotal['monthly'][$month] = 0;
            }

            foreach ($transaksi as $key => $menus) {
                $monthly = [];
                $total = 0;

                foreach ($months as $month) {
                    $monthly[$month] = 0;
                }

                foreach ($menus as $menu) {
                    $month = explode('-', $menu['tanggal'])[1];
                    $monthly[$months[$month]] += $menu['total'];
                    $total += $menu['total'];

                    $grandTotal['monthly'][$months[$month]] += $menu['total'];
                }

                $menusMap[$key]['monthly'] = $monthly;
                $menusMap[$key]['total'] = $total;

                $grandTotal['total'] += $total;
            }

            $resources = collect($menusMap)->groupBy('category');
        }

        return view('home', [
            'resources' => $resources,
            'months' => $months,
            'grandTotal' => $grandTotal ?? '',
            'period' => $request->get('tahun', '')
        ]);
    }
}
