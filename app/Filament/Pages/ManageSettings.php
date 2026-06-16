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

    protected array $fileKeys = ['hero_image', 'hero_video', 'about_image', 'about_video', 'company_logo'];

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
            'hero_title', 'hero_subtitle',
            'hero_image', 'hero_video', 'about_image', 'about_video', 'company_logo',
        ];

        foreach ($keys as $key) {
            $val = CompanySetting::get($key);
            $this->data[$key] = (in_array($key, $this->fileKeys) && $val) ? [$val] : $val;
        }

        $this->form->fill($this->data);
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Tabs::make()->tabs([
                Tab::make('Identitas')->schema([
                    TextInput::make('company_name')->label('Nama Perusahaan')->required(),
                    TextInput::make('company_tagline')->label('Tagline'),
                    Textarea::make('company_about')->label('Tentang Perusahaan')->rows(4)->columnSpanFull(),
                    Textarea::make('company_address')->label('Alamat')->rows(2),
                    TextInput::make('company_phone')->label('Telepon'),
                    TextInput::make('company_email')->label('Email')->email(),
                    TextInput::make('company_whatsapp')->label('WhatsApp'),
                    TextInput::make('company_instagram')->label('Instagram URL')->url(),
                    TextInput::make('company_facebook')->label('Facebook URL')->url(),
                ])->columns(2),

                Tab::make('Hero')->schema([
                    TextInput::make('hero_title')->label('Judul Hero')->columnSpanFull(),
                    Textarea::make('hero_subtitle')->label('Subtitle Hero')->rows(2)->columnSpanFull(),
                    FileUpload::make('hero_video')
                        ->label('Video Hero')->acceptedFileTypes(['video/mp4','video/webm'])
                        ->disk('public')->directory('settings')->maxSize(524288)->columnSpanFull(),
                    FileUpload::make('hero_image')
                        ->label('Gambar Hero (fallback)')->image()
                        ->disk('public')->directory('settings')->columnSpanFull(),
                ])->columns(2),

                Tab::make('Tentang')->schema([
                    FileUpload::make('about_video')
                        ->label('Video Tentang Kami')->acceptedFileTypes(['video/mp4','video/webm'])
                        ->disk('public')->directory('settings')->maxSize(524288)->columnSpanFull(),
                    FileUpload::make('about_image')
                        ->label('Gambar Tentang Kami (fallback)')->image()
                        ->disk('public')->directory('settings')->columnSpanFull(),
                ]),

                Tab::make('Logo')->schema([
                    FileUpload::make('company_logo')
                        ->label('Logo Perusahaan')->image()
                        ->disk('public')->directory('settings')->columnSpanFull(),
                ]),
            ])->columnSpanFull(),
        ])->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            if (in_array($key, $this->fileKeys) && is_array($value)) {
                $value = $value[0] ?? null;
            }
            $type = in_array($key, $this->fileKeys) ? 'image' : 'text';
            CompanySetting::set($key, $value, $type);
        }

        Notification::make()->title('Pengaturan berhasil disimpan!')->success()->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')->label('Simpan')->action('save')
                ->icon('heroicon-o-check')->color('primary'),
        ];
    }
}
