<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoodsResource\Pages;
use App\Filament\Resources\GoodsResource\RelationManagers;
use App\Models\Goods;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;


class GoodsResource extends Resource
{
    protected static ?string $model = Goods::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // フォームのフィールドを定義
        return $form->schema([
            Forms\Components\TextInput::make('goods_name')
                ->required() // 必須フィールドに設定
                ->label('Goods Name'),
            Forms\Components\TextInput::make('goods_series')
                ->label('Goods Series'),
			Forms\Components\TextInput::make('character')
                ->label('Character'),
            Forms\Components\DatePicker::make('goods_releasedate')
                ->label('Release Date'),
            FileUpload::make('imgpath')
				->label('Image')
				->disk('public') // Admin側の public ディスク
				->directory('goods_images') // 保存先ディレクトリ
				->visibility('public') // 公開アクセスを許可
				->image() // 画像ファイルを指定
				->maxSize(2048) // 最大サイズを2MBに設定
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
				ImageColumn::make('imgpath') // 画像カラムの設定
					->label('Image') // 表示ラベル
					->disk('public') // ストレージディスクを指定
					->size(50), // 表示する画像サイズ（50x50ピクセル）
				Tables\Columns\TextColumn::make('goods_name')->label('Goods Name'),
				Tables\Columns\TextColumn::make('goods_series')->label('Goods Series'),
				Tables\Columns\TextColumn::make('character')->label('Character'),
				Tables\Columns\TextColumn::make('goods_releasedate')->label('Release Date'),
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
            'index' => Pages\ListGoods::route('/'),
            'create' => Pages\CreateGoods::route('/create'),
            'edit' => Pages\EditGoods::route('/{record}/edit'),
        ];
    }
	
	public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        // 特定のデータベースからクエリを取得
        return Goods::on('chiikawatrade_db')->newQuery();
    }
	
}
