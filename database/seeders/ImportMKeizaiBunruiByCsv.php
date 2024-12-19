<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use League\Csv\Reader;
use Illuminate\Support\Facades\Log;
class ImportMKeizaiBunruiByCsv extends Seeder
{
    public function run()
    {
        // CSVファイルのパス（ヘッダーなし）
        $csvFile = storage_path('app/public/data.csv');
        Log::debug($csvFile);
        // CSVファイルが存在するか確認
        if (File::exists($csvFile)) {
            // CSVファイルを読み込む
            $csv = Reader::createFromPath($csvFile, 'r');
            $csv->setHeaderOffset(null); // ヘッダーなしとする
            Log::debug($csv);
            // CSVの各行をデータベースに挿入
            foreach ($csv as $row) {
                DB::table('m_keizai_sangyo_bunrui')->insert([
                    'daibunrui_id' => $row[0], // 1列目に該当
                    'daibunrui_name' => $row[1], // 2列目に該当
                    'chubunrui_id' => $row[2], // 3列目に該当
                    'chubunrui_name' => $row[3], // 4列目に該当
                    'shobunrui_id' => $row[4], // 5列目に該当
                    'shobunrui_name' => $row[5], // 6列目に該当
                    'saibunrui_id' => $row[6], // 7列目に該当
                    'saibunrui_name' => $row[7], // 8列目に該当
                ]);
            }

            echo "Data imported successfully.\n";
        } else {
            echo "CSV file not found.\n";
        }
    }
}