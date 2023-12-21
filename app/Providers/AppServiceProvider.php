<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Auth;

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
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {

            $role = Auth::user()->role;
            $event->menu->add(
                [
                    'text'=>'Dashboard',
                    'icon'=>'fas fa-cogs',
                    'route'=>'dashboard'
                ],
                [
                    'text' => 'Profile',
                    'icon' => 'fas fa-user',
                    'route' => 'profile'
                ]
            );

            switch($role){
                case 'admin':
                    $event->menu->add(
                        [
                            'text'=>'Settings',
                            'icon'=>'fas fa-list',
                            'submenu'=>[
                                [
                                    'text'=>'Countries',
                                    'route'=>'countries.index'
                                ],
                                [
                                    'text'=>'Services',
                                    'route'=>'services.index'
                                ],
                                [
                                    'text'=>'Users',
                                    'route'=>'users.index'
                                ]
                            ]
                        ]
                    );
                break;
            }

            $event->menu->add(
                [
                    'text'=>'Persons',
                    'icon'=>'fas fa-users',
                    'route'=>'persons.index'
                ],
                [
                    'text'=>'Shipments',
                    'icon'=>'fas fa-money-bill',
                    'route'=>'shipments.index'
                ],
                [
                    'text'=>'Reports',
                    'icon'=>'fas fa-file-pdf',
                    'submenu'=>[
                        [
                            'text'=>'Movements',
                            'route'=>'reports.movements'
                        ]
                    ]
                ]
            );

        });
    }
}
