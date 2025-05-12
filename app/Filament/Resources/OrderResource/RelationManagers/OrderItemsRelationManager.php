<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required()
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('product_variant_id', null);
                        $set('unit_price', \App\Models\Product::find($state)?->price ?? 0);
                        $set('total_price', function ($get) {
                            return $get('unit_price') * $get('quantity');
                        });
                    }),
                Forms\Components\Select::make('product_variant_id')
                    ->relationship('productVariant', 'name', function (Builder $query, $get) {
                        return $query->where('product_id', $get('product_id'));
                    })
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $price = \App\Models\ProductVariant::find($state)?->price_modifier ?? 0;
                            $set('unit_price', $price);
                            $set('total_price', function ($get) {
                                return $get('unit_price') * $get('quantity');
                            });
                        }
                    }),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $get) {
                        $set('total_price', $get('unit_price') * $state);
                    }),
                Forms\Components\TextInput::make('unit_price')
                    ->required()
                    ->numeric()
                    ->prefix('EGP')
                    ->disabled(),
                Forms\Components\TextInput::make('total_price')
                    ->required()
                    ->numeric()
                    ->prefix('EGP')
                    ->disabled(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('product.name'),
                Tables\Columns\TextColumn::make('productVariant.name')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->numeric(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->money('EGP'),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('EGP'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make()
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {
                        // Update the order total
                        $order = $record->order;
                        $order->total_amount = $order->orderItems->sum('total_price');
                        $order->save();
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->after(function ($record) {
                        // Update the order total
                        $order = $record->order;
                        $order->total_amount = $order->orderItems->sum('total_price');
                        $order->save();
                    }),
                Tables\Actions\DeleteAction::make()
                    ->after(function ($record) {
                        // Update the order total
                        $order = $record->order;
                        $order->total_amount = $order->orderItems->sum('total_price');
                        $order->save();
                    }),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->after(function () {
                            // Update the order total
                            $order = $this->ownerRecord;
                            $order->total_amount = $order->orderItems->sum('total_price');
                            $order->save();
                        }),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }
}
