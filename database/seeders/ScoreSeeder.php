<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ScoreSeeder extends Seeder
{
    public function run(): void
    {
        ini_set('memory_limit', '-1');
        DB::disableQueryLog();
        set_time_limit(3600);
        $file = storage_path('app/private/diem_thi_thpt_2024.csv');
        if (!file_exists($file)) {
            $this->command->error("File CSV không tồn tại: $file");
            return;
        }
        $batchSize = 5000;
        $rows = [];
        $this->command->info("Bắt đầu import điểm thi từ file CSV...");
        Schema::disableForeignKeyConstraints();

        if (($handle = fopen($file, 'r')) !== false) {
            $header = null;
            $this->command->info("Đang đọc và xử lý file CSV...");
            while (($data = fgetcsv($handle, 0, ",")) !== false) {
                if (!$header) {
                    $header = array_map(function ($item) {
                        return trim(strtolower($item));
                    }, $data);
                    continue;
                }
                if (count($data) !== count($header)) {
                    continue;
                }
                $row = array_combine($header, $data);
                $rows[] = [
                    'sbd' => $row['sbd'],
                    'toan' => $this->formatScore($row['toan']),
                    'ngu_van' => $this->formatScore($row['ngu_van']),
                    'ngoai_ngu' => $this->formatScore($row['ngoai_ngu']),
                    'vat_li' => $this->formatScore($row['vat_li']),
                    'hoa_hoc' => $this->formatScore($row['hoa_hoc']),
                    'sinh_hoc' => $this->formatScore($row['sinh_hoc']),
                    'lich_su' => $this->formatScore($row['lich_su']),
                    'dia_li' => $this->formatScore($row['dia_li']),
                    'gdcd' => $this->formatScore($row['gdcd']),
                    'ma_ngoai_ngu' => empty($row['ma_ngoai_ngu']) ? null : $row['ma_ngoai_ngu'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                if (count($rows) >= $batchSize) {
                    DB::table('scores')->insert($rows);
                    $rows = [];
                    gc_collect_cycles();
                }
            }
            if (!empty($rows)) {
                DB::table('scores')->insert($rows);
            }
            fclose($handle);
        }
        Schema::enableForeignKeyConstraints();
    }
    private function formatScore($score)
    {
        if ($score === '' || $score === null) {
            return null;
        }
        return str_replace(',', '.', trim($score));
    }
}