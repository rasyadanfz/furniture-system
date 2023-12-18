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
        $toInsert = [];
        $toSend = [];

        foreach ($daftar_pesanan as $key => $value) {
            $reviewDate = new DateTime($value->waktuPesanan);
            $reviewDate->add(new DateInterval('P' . rand(1,4) .'D'));
            $stringDate = $reviewDate->format('Y-m-d H:i:s');
            $max_rating = 10.0;
            // See if customer give reviews or not
            if (mt_rand(1,5) >= 3){
                $furniturData = $db->table('furnitures')->where('id', $value->furniture_id)->get()->getResult();
                $jenis_kayu = $furniturData[0]->jenisMaterial;
                $merek_kayu = $furniturData[0]->merekMaterial;
                $review = number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2);
                $tekstur = number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2);
                $ketahanan = number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2);
                $keperawatan = number_format(\App\Database\Seeds\ReviewSeeder::generateRandomNumber(1, $max_rating), 2);
                $temp = [
                    'pesanan_id' => $value->id,
                    'furniture_id' => $value->furniture_id,
                    'rating' => $review,
                    'durability_score' => $ketahanan,
                    'texture_score' => $tekstur,
                    'maintainability_score' => $keperawatan,
                    'date_created' => $stringDate,
                ];
                array_push($toInsert, $temp);
                $data = [
                    'jenis_kayu' => $jenis_kayu,
                    'merek_kayu' => $merek_kayu,
                    'review' => intval($review),
                    'tekstur' => intval($tekstur),
                    'ketahanan' => intval($ketahanan),
                    'keperawatan' => intval($keperawatan)
                ];
                array_push($toSend, $data);
            }
        }
        $this->db->table('reviews')->insertBatch($toInsert);
        $client = \Config\Services::curlrequest([
            'base_uri' => 'http://localhost:8080/',
        ]);
        $body = json_encode($toSend);
        $response = $client->request('POST', 'PenilaianPelanggan/save', [
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);
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
