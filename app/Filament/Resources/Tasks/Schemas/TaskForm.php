<?php

namespace App\Filament\Resources\Tasks\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Forms\Form;

class TaskForm
{
    public static function getSchema(): array
    {
        return [
            TextInput::make('title')
                ->label('Task Title')
                ->required()
                ->maxLength(255),

            Textarea::make('description')
                ->label('Description')
                ->rows(3)
                ->placeholder('Add details about this task...'),

            DatePicker::make('due_date')
                ->label('Due Date')
                ->native(false)
                ->displayFormat('F j, Y')
                ->helperText('Select when this task should be completed.'),

            Select::make('priority')
                ->label('Priority')
                ->options([
                    'low' => 'Low',
                    'medium' => 'Medium',
                    'high' => 'High',
                ])
                ->default('medium')
                ->required()
                ->helperText('Choose how important this task is.'),

            Toggle::make('is_completed')
                ->label('Completed?')
                ->inline(false),
        ];
    }
}
