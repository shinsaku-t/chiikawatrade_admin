<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Goods extends Model
{
    use HasFactory;

    // 使用する接続名を指定
    protected $connection = 'chiikawatrade_db';

    // テーブル名
    protected $table = 'goods';

    // 必要なら主キーやタイムスタンプの設定
	protected $fillable = ['goods_name', 'goods_series', 'goods_releasedate','character','imgpath'];
    protected $primaryKey = 'id';
    public $timestamps = true;
	
	protected static function boot()
    {
        parent::boot();

        static::saved(function ($goods) {
            // 画像がアップロードされた場合のみ同期を実行
            if ($goods->imgpath) {
                $filename = basename($goods->imgpath); // ファイル名を抽出
                $syncUrl = "https://chiikawatrade.com/sync-image/{$filename}";

                // 元サイトに同期リクエストを送信
                Http::get($syncUrl);
            }
        });
    }
}
