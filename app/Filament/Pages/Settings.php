<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class Settings extends Page implements Forms\Contracts\HasForms
{
    use Forms\Concerns\InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'System';

    protected static string $view = 'filament.pages.settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => Setting::get('site_name', 'My Blog'),
            'site_description' => Setting::get('site_description', 'A blog built with Laravel and Filament'),
            'posts_per_page' => Setting::get('posts_per_page', 10),
            'layout_style' => Setting::get('layout_style', 'sidebar'),
            'header_color' => Setting::get('header_color', '#f59e0b'),
            'enable_comments' => Setting::get('enable_comments', true),
            'social_github' => Setting::get('social_github', ''),
            'social_twitter' => Setting::get('social_twitter', ''),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Site Information')
                    ->schema([
                        Forms\Components\TextInput::make('site_name')
                            ->label('Site Name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('site_description')
                            ->label('Site Description')
                            ->maxLength(500)
                            ->rows(3),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Blog Settings')
                    ->schema([
                        Forms\Components\Select::make('posts_per_page')
                            ->label('Posts Per Page')
                            ->options([
                                5 => '5 posts',
                                10 => '10 posts',
                                15 => '15 posts',
                                20 => '20 posts',
                            ])
                            ->default(10)
                            ->required(),

                        Forms\Components\Select::make('layout_style')
                            ->label('Layout Style')
                            ->options([
                                'sidebar' => 'Sidebar Layout',
                                'top_navbar' => 'Top Navbar Layout',
                            ])
                            ->default('sidebar')
                            ->required(),

                        Forms\Components\Toggle::make('enable_comments')
                            ->label('Enable Comments')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Appearance')
                    ->schema([
                        Forms\Components\ColorPicker::make('header_color')
                            ->label('Header Color')
                            ->default('#f59e0b'),
                    ])
                    ->columns(1),

                Forms\Components\Section::make('Social Media')
                    ->schema([
                        Forms\Components\TextInput::make('social_github')
                            ->label('GitHub URL')
                            ->url()
                            ->placeholder('https://github.com/username'),

                        Forms\Components\TextInput::make('social_twitter')
                            ->label('Twitter URL')
                            ->url()
                            ->placeholder('https://twitter.com/username'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Settings')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            foreach ($data as $key => $value) {
                Setting::set($key, $value);
            }

            Notification::make()
                ->success()
                ->title('Settings saved successfully!')
                ->send();

        } catch (Halt $exception) {
            return;
        }
    }
}
