<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParrainResource\Pages;
use App\Models\Parrain;
use App\Models\Electeur;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;

class ParrainResource extends Resource
{
    protected static ?string $model = Parrain::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationGroup = 'Gestion des Parrainages';

    protected static ?string $modelLabel = 'Parrain';

    protected static ?string $pluralModelLabel = 'Parrains';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('cin')
                    ->label('Numéro CIN')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(13),
                
                TextInput::make('numero_electeur')
                    ->label('Numéro Électeur')
                    ->required()
                    ->unique(ignoreRecord: true),
                
                TextInput::make('prenom')
                    ->label('Prénom')
                    ->required()
                    ->maxLength(100),
                
                TextInput::make('nom')
                    ->label('Nom')
                    ->required()
                    ->maxLength(100),
                
                DatePicker::make('date_naissance')
                    ->label('Date de Naissance')
                    ->required(),
                
                TextInput::make('lieu_naissance')
                    ->label('Lieu de Naissance')
                    ->required()
                    ->maxLength(100),
                
                Select::make('sexe')
                    ->label('Sexe')
                    ->options([
                        'M' => 'Masculin',
                        'F' => 'Féminin'
                    ])
                    ->required(),
                
                TextInput::make('telephone')
                    ->label('Téléphone')
                    ->tel()
                    ->required(),
                
                TextInput::make('bureau_vote')
                    ->label('Bureau de Vote')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('cin')
                    ->label('CIN')
                    ->searchable(),
                
                TextColumn::make('numero_electeur')
                    ->label('N° Électeur')
                    ->searchable(),
                
                TextColumn::make('prenom')
                    ->label('Prénom')
                    ->searchable(),
                
                TextColumn::make('nom')
                    ->label('Nom')
                    ->searchable(),
                
                TextColumn::make('date_naissance')
                    ->label('Date Naissance')
                    ->date(),
                
                TextColumn::make('telephone')
                    ->label('Téléphone'),
                
                TextColumn::make('created_at')
                    ->label('Date Création')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListParrains::route('/'),
            'create' => Pages\CreateParrain::route('/create'),
            'edit' => Pages\EditParrain::route('/{record}/edit'),
        ];
    }    
}
