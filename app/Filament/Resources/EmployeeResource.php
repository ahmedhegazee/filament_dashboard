<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Filament\Resources\EmployeeResource\Widgets\EmployeesCountWidget;
use App\Models\City;
use App\Models\Country;
use App\Models\Employee;
use App\Models\State;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Grid::make(2)->schema([
                        TextInput::make('first_name')->required()->minLength(4)->maxLength(120),
                        TextInput::make('last_name')->required()->minLength(4)->maxLength(120),
                        TextInput::make('address')->required()->minLength(4)->maxLength(120),
                        TextInput::make('zip_code')->required()->minLength(4)->maxLength(120),
                        DatePicker::make('birth_date')->required(),
                        DatePicker::make('hired_date')->required(),
                        Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name', 'id')->toArray())
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),
                        Select::make('state_id')
                            ->label('State')
                            ->required()
                            ->options(function (callable $get) {
                                $country = Country::find($get('country_id'));
                                if (!$country) {
                                    return [];
                                }
                                return $country->states->pluck('name', 'id');
                            })
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                        Select::make('city_id')
                            ->label('City')
                            ->options(function (callable $get) {
                                $state = State::find($get('state_id'));
                                if (!$state) {
                                    return [];
                                }
                                return $state->cities->pluck('name', 'id');
                            })
                            ->required()
                            ->reactive(),
                        Select::make('department_id')->label('Department')->relationship('department', 'name')->searchable()->required()

                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        // protected $fillable = ['first_name', 'last_name', 'address', 'zip_code', 'birth_date', 'hired_date', 'department_id', 'state_id', 'city_id', 'country_id'];
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('full_name')->searchable(['first_name', 'last_name']),
                // TextColumn::make('first_name')->searchable(),
                // TextColumn::make('last_name')->searchable(),
                // TextColumn::make('state.name')->searchable()->sortable(),
                // TextColumn::make('country.name')->searchable()->sortable(),
                // TextColumn::make('city.name')->searchable()->sortable(),
                TextColumn::make('department.name')->searchable()->sortable(),
                TextColumn::make('hired_date')->date(),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('department')->relationship('department', 'name')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
    public static function getWidgets(): array
    {
        return [
            EmployeesCountWidget::class
        ];
    }
}