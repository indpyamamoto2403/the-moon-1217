<?php
namespace App\DomainLogic\Prompts;

class Prompts
{

    /**
     * テスト用のプロンプト
     */
    public static $testPrompts = 
    <<<EOF
    丸くて赤くて甘い果物で有名なものは何ですか？3文字で答えてください。
    EOF;

    /**
     * テスト用の動的プロンプト
     * @param string $prompt プロンプト内容
     * @return string 動的プロンプト
     */
    public static function dynamicPrompts(string $prompt): string
    {
        return <<<EOF
        $prompt
        EOF;
    }

    /**
     * 会社概要から経済産業分類を行うプロンプト
     * @param string $overview 会社概要
     * @param string $keizai_sangyo_list 経済産業分類リスト
     * @return string 経済産業分類プロンプト
     */
    public static function economyClassification(string $overview, string $keizai_sangyo_list): string
    {
        return <<<EOF
        #課題
        経済産業分類を以下とする。
        ある企業の概要文があるので、その概要文が
        いずれかに該当する数字に分けてほしい。

        #概要文
        $overview

        #経済産業分類
        $keizai_sangyo_list

        #返却データ型
        string(1)

        #形式
        {"classification":""}
        EOF;
    }
}