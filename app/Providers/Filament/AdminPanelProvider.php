<?php

namespace App\Providers\Filament;

use App\Models\User;
use App\Models\SocialiteUser;
use DutchCodingCompany\FilamentSocialite\FilamentSocialitePlugin;
use DutchCodingCompany\FilamentSocialite\Provider;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->registration()
            ->profile()
            ->sidebarCollapsibleOnDesktop()
            ->maxContentWidth('full')
            ->darkMode(true)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\Home::class,
                \App\Filament\Pages\About::class,
                \App\Filament\Pages\Blog::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Blog')
                    ->icon('heroicon-o-pencil-square'),
                NavigationGroup::make()
                    ->label('Administration')
                    ->icon('heroicon-o-cog')
                    ->collapsed(),
            ])
            ->navigationItems([
                NavigationItem::make('Home')
                    ->url('/')
                    ->icon('heroicon-o-home')
                    ->sort(0),
                NavigationItem::make('About')
                    ->url('/about')
                    ->icon('heroicon-o-information-circle')
                    ->sort(1),
                NavigationItem::make('Blog')
                    ->url('/blog')
                    ->icon('heroicon-o-newspaper')
                    ->sort(2),
            ])
            ->plugin(
                FilamentSocialitePlugin::make()
                    ->providers([
                        Provider::make('github')
                            ->label('GitHub')
                            ->icon('fab-github')
                            ->color(Color::hex('#24292f')),
                    ])
                    ->userModelClass(User::class)
                    ->socialiteUserModelClass(SocialiteUser::class)
                    ->createUserUsing(function (string $provider, SocialiteUserContract $oauthUser) {
                        $user = User::create([
                            'name' => $oauthUser->getName(),
                            'email' => $oauthUser->getEmail(),
                            'password' => null,
                            'avatar' => $oauthUser->getAvatar(),
                            'github_id' => $oauthUser->getId(),
                        ]);

                        $user->assignRole('user');

                        return $user;
                    })
                    ->registration(true)
            );
    }
}
