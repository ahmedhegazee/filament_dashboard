<?php

namespace App\Filament\Resources\DepartmentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeesRelationManager extends RelationManager
{
    protected static string $relationship = 'employees';

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('first_name')->required()->minLength(4)->maxLength(120),
                TextInput::make('last_name')->required()->minLength(4)->maxLength(120),
                TextInput::make('address')->required()->minLength(4)->maxLength(120),
                TextInput::make('zip_code')->required()->minLength(4)->maxLength(120),
                DatePicker::make('birth_date')->required(),
                DatePicker::make('hired_date')->required(),
                //               Select::make('state_id')
                //     ->label('State')
                //     ->required()
                //     ->options(State::all()->pluck('name', 'id')->toArray())
                //     ->reactive()
                //     ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                // Select::make('city_id')
                //     ->label('City')
                //     ->options(function (callable $get) {
                //         $state = State::find($get('state_id'));
                //         if (!$state) {
                //             return [];
                //         }
                //         return $state->cities->pluck('name', 'id');
                //     })
                //     ->required()
                //     ->reactive(),
                // Select::make('department_id')->label('Department')->relationship('department', 'name')->searchable()->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('full_name')->searchable(['first_name', 'last_name']),
                TextColumn::make('department.name')->searchable()->sortable(),
                TextColumn::make('hired_date')->date(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                // Tables\Actions\CreateAction::make(),
                // Tables\Actions\AssociateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Tables\Actions\DissociateAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DissociateBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}