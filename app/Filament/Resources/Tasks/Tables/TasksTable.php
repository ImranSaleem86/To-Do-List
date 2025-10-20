<?php

namespace App\Filament\Resources\Tasks\Tables;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Notifications\Notification;
use Filament\Actions\EditAction;
use Filament\Actions\Action;

class TasksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('priority')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'high' => 'danger',
                        'medium' => 'warning',
                        'low' => 'success',
                        default => 'gray',
                    })
                    ->label('Priority'),

                TextColumn::make('due_date')
                    ->date()
                    ->sortable()
                    ->label('Due Date'),

                IconColumn::make('is_completed')
                    ->boolean()
                    ->label('Completed'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (Task $record): string => route('filament.admin.resources.tasks.edit', $record)),
                DeleteAction::make(),
                Action::make('mark_done')
                    ->label('Mark as Done')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn (Task $record): bool => !$record->is_completed)
                    ->requiresConfirmation()
                    ->action(function (Task $record) {
                        $record->update(['is_completed' => true]);

                        Notification::make()
                            ->title('Task Completed 🎉')
                            ->body("“{$record->title}” marked as done successfully.")
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
