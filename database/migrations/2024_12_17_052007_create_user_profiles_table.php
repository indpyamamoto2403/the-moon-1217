<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id(); // 自動的にプライマリキーとなるID
            $table->unsignedBigInteger('user_id')->unique(); // ユーザーID、ユニーク制約を追加
            $table->string('name'); // 名前
            $table->string('email')->unique(); // メールアドレス（ユニーク）
            $table->string('company_name')->nullable(); // 会社名
            $table->string('department')->nullable(); // 部署
            $table->string('position')->nullable(); // 役職
            $table->string('zip_code')->nullable(); // 郵便番号
            $table->string('address')->nullable(); // 住所
            $table->string('company_url')->nullable(); // 会社URL
            $table->text('company_overview')->nullable(); // 会社概要
            $table->timestamps(); // created_at と updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
