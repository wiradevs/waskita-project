<?php

namespace App\Filament\Pages;

use App\Models\CompanySetting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;

class ManageSettings extends Page
{
    protected static ?string $navigationLabel = 'Pengaturan';
    protected static ?string $title = 'Pengaturan Perusahaan';
    protected string $view = 'filament.pages.manage-settings';

    public array $data = [];

    public static function getNavigationIcon(): ?string
    {
        return 'heroicon-o-cog-6-tooth';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Pengaturan';
    }

    public function mount(): void
    {
        $keys = [
            'company_name', 'company_tagline', 'company_about',
            'company_address', 'company_phone', 'company_email',
            'company_whatsapp', 'company_instagram', 'company_facebook',
            'hero_title', 'hero_subtitle', 'hero_image', 'hero_video', 'company_logo',
        ];

        foreach ($keys as $key) {
            $this->data[$key] = CompanySetting::get($key);
        }

        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->tabs([
                Tab::make('Identitas Perusahaan')->schema([
                    TextInput::make('company_name')
                        ->label('Nama Perusahaan')
                        ->required(),
                    TextInput::make('company_tagline')
                        ->label('Tagline / Slogan'),
                    Textarea::make('company_about')
                        ->label('Tentang Perusahaan')
                        ->rows(5)
                        ->columnSpanFull(),
                    Textarea::make('company_address')
                        ->label('Alamat')
                        ->rows(3),
                    TextInput::make('company_phone')
                        ->label('Nomor Telepon'),
                    TextInput::make('company_email')
                        ->label('Email')
                        ->email(),
                    TextInput::make('company_whatsapp')
                        ->label('WhatsApp'),
                ])->columns(2),

                Tab::make('Sosial Media')->schema([
                    TextInput::make('company_instagram')
                        ->label('Instagram URL')
                        ->url(),
                    TextInput::make('company_facebook')
                        ->label('Facebook URL')
                        ->url(),
                ])->columns(2),

                Tab::make('Hero Section')->schema([
                    TextInput::make('hero_title')
                        ->label('Judul Hero (Baris 1)')
                        ->columnSpanFull(),
                    Textarea::make('hero_subtitle')
                        ->label('Subtitle Hero')
                        ->rows(3)
                        ->columnSpanFull(),
                    FileUpload::make('hero_video')
                        ->label('Video Hero (MP4 — diutamakan)')
                        ->acceptedFileTypes(['video/mp4', 'video/webm'])
                        ->disk('public')
                        ->directory('settings')
                        ->maxSize(102400)
                        ->helperText('Upload video MP4/WebM. Ukuran max 100 MB. Akan diputar otomatis tanpa suara.')
                        ->columnSpanFull(),
                    FileUpload::make('hero_image')
                        ->label('Gambar Hero (fallback jika tidak ada video)')
                        ->image()
                        ->disk('public')
                        ->directory('settings')
                        ->columnSpanFull(),
                ])->columns(2),

                Tab::make('Logo')->schema([
                    FileUpload::make('company_logo')
                        ->label('Logo Perusahaan')
                        ->image()
                        ->disk('public')
                        ->directory('settings')
                        ->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();
        $imageKeys = ['hero_image', 'hero_video', 'company_logo'];

        foreach ($data as $key => $value) {
            $type = in_array($key, $imageKeys) ? 'image' : 'text';
            CompanySetting::set($key, $value, $type);
        }

        Notification::make()
            ->title('Pengaturan berhasil disimpan!')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Pengaturan')
                ->action('save')
                ->icon('heroicon-o-check')
                ->color('primary'),
        ];
    }
}
