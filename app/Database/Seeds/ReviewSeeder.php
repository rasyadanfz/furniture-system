<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use DateInterval, DateTime;

class ReviewSeeder extends Seeder
{
    public function run()
    {

        $query = "ALTER TABLE reviews AUTO_INCREMENT = 1";
        $this->db->query($query);

        $db = db_connect();
        $query_pesanan = $db->table('pesanan')->get();
        $daftar_pesanan = $query_pesanan->getResult();

        foreach ($daftar_pesanan as $key => $value) {
            $reviewDate = new DateTime($value->waktuPesanan);
            $reviewDate->add(new DateInterval('P' . rand(1,4) .'D'));
            $stringDate = $reviewDate->format('Y-m-d H:i:s');
            $max_rating = 10.0;
            // See if customer give reviews or not
            if (mt_rand(1,5) >= 3){
                $temp = [
                    'pesanan_id' => $value->id,
                    'furniture_id' => $value->furniture_id,
                    'rating' => number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2),
                    'durability_score' => number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2),
                    'texture_score' => number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2),
                    'maintainability_score' => number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2),
                    'date_created' => $stringDate,
                ];
                $this->db->table('reviews')->insert($temp);
            }
        }

    }

    private function generateRandomNumber($min, $max){
        $random_int = random_int(PHP_INT_MIN, PHP_INT_MAX);
        $random_float = \App\Database\Seeds\ReviewSeeder::mapToRange($random_int, PHP_INT_MIN, PHP_INT_MAX, $min, $max);
        // Add a random decimal value between -2 and 2 for more randomness
        $random_salt = ((mt_rand() / mt_getrandmax()) * 4) - 2;
        $random_float += $random_salt;

        // Ensure that the final result stays within the specified range
        $random_float = max($min, min($max, $random_float));
        return $random_float;
    }

    private function mapToRange($value, $fromMin, $fromMax, $toMin, $toMax) {
        // Ensure that the value is within the source range
        $value = max($fromMin, min($fromMax, $value));
        
        // Map the value to the target range
        $fromRange = $fromMax - $fromMin;
        $toRange = $toMax - $toMin;
    
        if ($fromRange == 0) {
            return $toMin;
        } else {
            return $toMin + (($value - $fromMin) / $fromRange) * $toRange;
        }
    }
}
