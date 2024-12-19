<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMKeizaiSangyoBunruiTable extends Migration
{
    /**
     * マイグレーションを実行する
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_keizai_sangyo_bunrui', function (Blueprint $table) {
            $table->id();  // idカラム（主キー、自動インクリメント）
            $table->string('daibunrui_id', 1);  // 大分類ID（アルファベット1文字）
            $table->string('daibunrui_name');  // 大分類名
            $table->integer('chubunrui_id');  // 中分類ID
            $table->string('chubunrui_name');  // 中分類名
            $table->integer('shobunrui_id');  // 小分類ID
            $table->string('shobunrui_name');  // 小分類名
            $table->integer('saibunrui_id');  // 細分類ID
            $table->string('saibunrui_name');  // 細分類名
            $table->timestamps();  // created_at と updated_at
        });
    }

    /**
     * マイグレーションをロールバックする
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_keizai_sangyo_bunrui');
    }
}