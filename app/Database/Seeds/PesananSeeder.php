<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use DateInterval;
use DateTime;

class PesananSeeder extends Seeder
{
    public function run()
    {
        function getSubtractedDate($daysToSubtract){
            $date = new DateTime();
            $interval = new DateInterval('P' . $daysToSubtract. 'D');
            $date->sub($interval);
            $stringDate = $date->format('Y-m-d H:i:s');
            return $stringDate;
        }

        $query = "ALTER TABLE pesanan AUTO_INCREMENT = 1";
        $this->db->query($query);

        $db = db_connect();
        $builder = $db->table('furnitures');
        $query = $builder->get();
        $result = $query->getResult();

        $builder2 = $db->table('customers');
        $query2 = $builder2->get();
        $result2 = $query2->getResult();
        foreach($result2 as $key => $custData){
            foreach ($result as $key => $value) {
                // Will the current item be purchased/not
                $willBePurchased = rand(0,1);
                if ($willBePurchased == 0) {
                    continue;
                }
                $qty = rand(1,5);
                $temp = [
                    'waktuPesanan' => getSubtractedDate(rand(1,60)),
                    'customer_id' => $custData->id,
                    'kuantitas' => $qty,
                    'total_harga' => $value->harga * $qty,
                    'furniture_id' => $value->id,
                ];
                $this->db->table('pesanan')->insert($temp);

                // Will the customer buy again or not
                $purchaseAgain = rand(0,1);
                if ($purchaseAgain == 1) {
                    $qty = rand(1,5);
                    $temp = ['waktuPesanan' => getSubtractedDate(rand(1,60)),
                    'customer_id' => $custData->id,
                    'kuantitas' => $qty,
                    'total_harga' => $value->harga * $qty,
                    'furniture_id' => $value->id,
                ];
                $this->db->table('pesanan')->insert($temp);
                }
            }
        }


    }
}
