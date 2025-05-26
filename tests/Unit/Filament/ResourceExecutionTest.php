<?php

use App\Filament\Resources\CategoryResource;
use App\Filament\Resources\PageResource;
use App\Filament\Resources\PostResource;
use App\Filament\Resources\TagResource;
use Filament\Forms\Form;
use Filament\Tables\Table;

describe('Resource Method Execution', function () {
    it('PostResource form method executes successfully', function () {
        $mockForm = Mockery::mock(Form::class)->makePartial();
        $mockForm->shouldReceive('schema')->andReturnSelf();

        $result = PostResource::form($mockForm);
        expect($result)->toBeInstanceOf(Form::class);
    });

    it('PostResource table method executes successfully', function () {
        $mockTable = Mockery::mock(Table::class)->makePartial();
        $mockTable->shouldReceive('columns')->andReturnSelf();
        $mockTable->shouldReceive('filters')->andReturnSelf();
        $mockTable->shouldReceive('actions')->andReturnSelf();
        $mockTable->shouldReceive('bulkActions')->andReturnSelf();
        $mockTable->shouldReceive('defaultSort')->andReturnSelf();

        $result = PostResource::table($mockTable);
        expect($result)->toBeInstanceOf(Table::class);
    });

    it('CategoryResource form method executes successfully', function () {
        $mockForm = Mockery::mock(Form::class)->makePartial();
        $mockForm->shouldReceive('schema')->andReturnSelf();

        $result = CategoryResource::form($mockForm);
        expect($result)->toBeInstanceOf(Form::class);
    });

    it('CategoryResource table method executes successfully', function () {
        $mockTable = Mockery::mock(Table::class)->makePartial();
        $mockTable->shouldReceive('columns')->andReturnSelf();
        $mockTable->shouldReceive('filters')->andReturnSelf();
        $mockTable->shouldReceive('actions')->andReturnSelf();
        $mockTable->shouldReceive('bulkActions')->andReturnSelf();
        $mockTable->shouldReceive('defaultSort')->andReturnSelf();

        $result = CategoryResource::table($mockTable);
        expect($result)->toBeInstanceOf(Table::class);
    });

    it('PageResource form method executes successfully', function () {
        $mockForm = Mockery::mock(Form::class)->makePartial();
        $mockForm->shouldReceive('schema')->andReturnSelf();

        $result = PageResource::form($mockForm);
        expect($result)->toBeInstanceOf(Form::class);
    });

    it('PageResource table method executes successfully', function () {
        $mockTable = Mockery::mock(Table::class)->makePartial();
        $mockTable->shouldReceive('columns')->andReturnSelf();
        $mockTable->shouldReceive('filters')->andReturnSelf();
        $mockTable->shouldReceive('actions')->andReturnSelf();
        $mockTable->shouldReceive('bulkActions')->andReturnSelf();
        $mockTable->shouldReceive('defaultSort')->andReturnSelf();

        $result = PageResource::table($mockTable);
        expect($result)->toBeInstanceOf(Table::class);
    });

    it('TagResource form method executes successfully', function () {
        $mockForm = Mockery::mock(Form::class)->makePartial();
        $mockForm->shouldReceive('schema')->andReturnSelf();

        $result = TagResource::form($mockForm);
        expect($result)->toBeInstanceOf(Form::class);
    });

    it('TagResource table method executes successfully', function () {
        $mockTable = Mockery::mock(Table::class)->makePartial();
        $mockTable->shouldReceive('columns')->andReturnSelf();
        $mockTable->shouldReceive('filters')->andReturnSelf();
        $mockTable->shouldReceive('actions')->andReturnSelf();
        $mockTable->shouldReceive('bulkActions')->andReturnSelf();
        $mockTable->shouldReceive('defaultSort')->andReturnSelf();

        $result = TagResource::table($mockTable);
        expect($result)->toBeInstanceOf(Table::class);
    });
});
