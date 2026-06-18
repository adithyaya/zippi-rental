<?php

namespace App\Filament\Resources\CustomerDocuments;

use App\Filament\Resources\CustomerDocuments\Pages\CreateCustomerDocument;
use App\Filament\Resources\CustomerDocuments\Pages\EditCustomerDocument;
use App\Filament\Resources\CustomerDocuments\Pages\ListCustomerDocuments;
use App\Filament\Resources\CustomerDocuments\Schemas\CustomerDocumentForm;
use App\Filament\Resources\CustomerDocuments\Tables\CustomerDocumentsTable;
use App\Models\CustomerDocument;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CustomerDocumentResource extends Resource
{
    protected static ?string $model = CustomerDocument::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'document_number';

    public static function form(Schema $schema): Schema
    {
        return CustomerDocumentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CustomerDocumentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCustomerDocuments::route('/'),
            'create' => CreateCustomerDocument::route('/create'),
            'edit' => EditCustomerDocument::route('/{record}/edit'),
        ];
    }
}
