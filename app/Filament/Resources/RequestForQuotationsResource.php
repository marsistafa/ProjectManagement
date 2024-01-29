<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestForQuotationsResource\Pages;
use App\Filament\Resources\RequestForQuotationsResource\RelationManagers;
use App\Models\RequestForQuotation;
use App\Models\RFQDocument;
use App\Models\RFQDetail;
use App\Models\Material;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\Modal;
use Filament\Forms\Components\Button;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Repeater;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Action;
use App\Http\Livewire\AddMaterialModal;
use Filament\Forms\Components\Section;
use App\Http\Controllers\RFQDocumentController;
use App\Models\TicketComment;
use Filament\Forms\Components\RichEditor;

class RequestForQuotationsResource extends Resource
{
    protected static ?string $model = RequestForQuotation::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?int $navigationSort = 3;

    protected bool $showAddMaterialModal = false;

    protected static function getNavigationLabel(): string
    {
        return __('RequestForQuotations');
    }

    public static function getPluralLabel(): ?string
    {
        return static::getNavigationLabel();
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('Management');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('rfq_number')
                ->default(RequestForQuotation::generateNextRfqNumber())
                ->required()
                ->disabled(),
                Forms\Components\DatePicker::make('deadline')
                    ->required(),
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'name')
                    ->required(),
                Forms\Components\Select::make('supplier_id')
                    ->label('Supplier')
                    ->searchable()
                    ->reactive()
                    ->options(fn() => array_merge(
                        Supplier::all()->pluck('name', 'id')->toArray()))
                    ->required(),
                Forms\Components\Select::make('created_by')
                    ->label('User')
                    ->default(fn() => Auth::user()->id)
                    ->disabled()
                    
                    ->relationship('creator', 'name')
                    ->required(),
                Forms\Components\Toggle::make('is_approved')
                    ->disabled(fn ($record) => !in_array(auth()->user()->id, [3, 6])),
                Forms\Components\TextInput::make('solution_id')->hidden(),

                Forms\Components\Hidden::make('rfqDetailsSum'),

                Forms\Components\TextInput::make('transport_cost')
                    ->numeric()
                    ->reactive()
                    ->rules('numeric|min:0')
                    ->afterStateUpdated(function ($state, $get, $set, $livewire) {
                        
                        $rfqDetails = $livewire->rfqDetailsSum;
                        $otherCost = $get('other_cost')??0;
                        $discount = $get('discount')??0;
                        $discountAmount = ($otherCost + $state + $rfqDetails) * $discount/100 ;

                        $set('total_excl_tax', $otherCost + $state + $rfqDetails - $discountAmount );
                        $set('tax', ($otherCost + $state + $rfqDetails - $discountAmount)* 0.20 );
                        $set('total_incl_tax', $get('total_excl_tax') + $get('tax'));
                        
                    }),

                Forms\Components\TextInput::make('other_cost')
                    ->numeric()
                    ->rules('numeric|min:0')
                    ->reactive()
                    ->afterStateUpdated(function ($state, $get, $set, $livewire) {

                        $rfqDetails = $livewire->rfqDetailsSum;
                        $transportCost = $get('transport_cost')??0;
                        $discount = $get('discount')??0;
                        $discountAmount = ($transportCost + $state + $rfqDetails) * $discount/100 ;

                        $set('total_excl_tax', $transportCost + $state + $rfqDetails - $discountAmount );
                        $set('tax', ($transportCost + $state + $rfqDetails - $discountAmount)* 0.20 );
                        $set('total_incl_tax', $get('total_excl_tax') + $get('tax'));
                        
                    }),

                Forms\Components\TextInput::make('discount')
                    ->label('Discount %')
                    ->numeric()
                    ->rules('numeric|min:0')
                    ->reactive()
                    ->afterStateUpdated(function ($state, $get, $set, $livewire) {

                        $rfqDetails = $livewire->rfqDetailsSum;
                        $transportCost = $get('transport_cost');
                        $otherCost = $get('other_cost');
                        $totalExclTax = $transportCost + $otherCost + $rfqDetails;

                        $set('total_excl_tax', $totalExclTax - ($totalExclTax * $state/100) );
                        $set('tax', ($totalExclTax - ($totalExclTax * $state/100))* 0.20 );
                        $set('total_incl_tax', $get('total_excl_tax') + $get('tax'));
                        
                    }),

                Forms\Components\TextInput::make('total_excl_tax')
                    ->numeric()
                    ->reactive()
                    ->disabled(),
    
                Forms\Components\TextInput::make('tax')
                    ->numeric()
                    ->reactive()
                    ->disabled(),
    
                Forms\Components\TextInput::make('total_incl_tax')
                    ->numeric()
                    ->reactive()
                    ->disabled(),
                
                Forms\Components\Textarea::make('payment_conditions')
                    ->rows(1),
                Forms\Components\Textarea::make('product_warranty')
                    ->rows(1),
                Forms\Components\Textarea::make('delivery_terms')
                    ->rows(1),
                Forms\Components\Textarea::make('delivery_place')
                    ->rows(1),
    

                Forms\Components\FileUpload::make('rfqDocuments')
                                ->label(__('Documents'))
                                ->multiple()
                                ->columnSpan(2)
                                ->default(fn($record) => $record 
                                ? RFQDocument::where('request_for_quotation_id', $record->id)->pluck('document_path') 
                                : [])
                                ->saveUploadedFileUsing(function ($file, $record) {
                                   
                                    $data = [
                                        'document_path' => $file,
                                        'request_for_quotation_id' => $record->id,
                                    ];
                                    
                                    $request = new \Illuminate\Http\Request();
                                    $request->replace($data);
                                    
                                    $controller = new RFQDocumentController();
                                    $document = $controller->store($request);       
                                })
                            ])
                            
                ->columns(6);
    }
    
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rfq_number'),
                Tables\Columns\TextColumn::make('deadline')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('project.name'),
                Tables\Columns\TextColumn::make('supplier.name'),
                Tables\Columns\TextColumn::make('creator.name'),
                Tables\Columns\BooleanColumn::make('is_approved'),
                Tables\Columns\TextColumn::make('solution_id'),
                Tables\Columns\TextColumn::make('transport_cost'),
                Tables\Columns\TextColumn::make('other_cost'),
                Tables\Columns\TextColumn::make('discount'),
                Tables\Columns\TextColumn::make('total_excl_tax'),
                Tables\Columns\TextColumn::make('tax'),
                Tables\Columns\TextColumn::make('total_incl_tax'),
                Tables\Columns\TextColumn::make('payment_conditions'),
                Tables\Columns\TextColumn::make('product_warranty'),
                Tables\Columns\TextColumn::make('delivery_terms'),
                Tables\Columns\TextColumn::make('delivery_place'),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            RelationManagers\RfqDetailsRelations::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequestForQuotations::route('/'),
            'create' => Pages\CreateRequestForQuotations::route('/create'),
            'edit' => Pages\EditRequestForQuotations::route('/{record}/edit'),
        ];
    }    


}
