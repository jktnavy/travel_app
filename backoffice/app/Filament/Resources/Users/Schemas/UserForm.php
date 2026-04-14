<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Validation\Rules\Password;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('employee_code')
                    ->unique(ignoreRecord: true),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->unique(ignoreRecord: true)
                    ->required(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('password')
                    ->password()
                    ->rule(Password::default())
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->required(fn (string $operation): bool => $operation === 'create'),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                DateTimePicker::make('last_login_at'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
