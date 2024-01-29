<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class Chat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat';

    protected static string $view = 'vendor.Chatify.pages.app';
    
    protected static ?string $slug = 'chat';
    
    protected static ?int $navigationSort = 1; // Adjust the sort order as needed
    
    protected static function getNavigationLabel(): string
    {
        return __('Chat');
    }
    
    protected static function getNavigationGroup(): ?string
    {
        return __('Chatify');
    }
}