<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Menu;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Bagikan data menu ke partial/komponen sidebar Anda
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // Ambil ID dari role-role yang dimiliki user yang sedang login
                // Sesuaikan jika user Anda hanya memiliki satu role (e.g., $user->role_id)
                // $roleIds = $user->roles->pluck('id')->toArray();
                // Ganti baris $roleIds kemarin dengan ini jika memakai Pilihan B:
                $roleIds = [$user->role_id];

                // Ambil menu utama (parent_id IS NULL) yang aktif dan dimiliki oleh role user tersebut
                $sidebarMenus = Menu::whereNull('parent_id')
                    ->where('is_active', 1)
                    ->whereHas('roles', function ($query) use ($roleIds) {
                        $query->whereIn('roles.id', $roleIds);
                    })
                    ->with(['children' => function ($query) use ($roleIds) {
                        // Ambil juga sub-menu (children) yang aktif dan sesuai role
                        $query->where('is_active', 1)
                            ->whereHas('roles', function ($q) use ($roleIds) {
                                $q->whereIn('roles.id', $roleIds);
                            })
                            ->orderBy('sort_order', 'asc');
                    }])
                    ->orderBy('sort_order', 'asc')
                    ->get();

                $view->with('sidebarMenus', $sidebarMenus);
            }
        });
    }
}
