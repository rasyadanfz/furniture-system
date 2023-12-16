<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FurnitureModel;
use App\Models\PesananModel;
use App\Models\ReviewModel;
use CodeIgniter\RESTful\ResourceController;

class UserInsightsAPI extends ResourceController
{
    public function index()
    {
        // Get 3 most popular furniture items based on the number of orders
        $data['most_popular_furnitures'] = \App\Controllers\UserInsightsAPI::getPopularFurnitures();

        // Get trending materials based on orders 2 30-days period (-60 to -30 and -30 to current day)
        $data['materials_demand_increase_percentage'] = \App\Controllers\UserInsightsAPI::getTrendingMaterial();

        // Get users most durable furniture (based on reviews)
        $data['most_durable_material'] = \App\Controllers\UserInsightsAPI::getMostDurableFurnitures();

        // Respond with data
        $data['message'] = "success";

        return $this->respond($data, 200);
    }

    private function getTrendingMaterial(){
        $orders_model = model(PesananModel::class);
        $materialOrderList = $orders_model->getMaterialOrderSummary();
        $pastMaterialOrder = $materialOrderList['past'];
        $currentMaterialOrder = $materialOrderList['current'];
        $change = [];

        // Calculate the change. If material only exists on current, set change to 100
        // Add name and the change to $change
        foreach($currentMaterialOrder as $item){
            foreach($pastMaterialOrder as $pastItem){
                if($item->material == $pastItem->material){
                    $change[$item->material] = $item->jumlah - $pastItem->jumlah;
                }
            }
            if(!isset($change[$item->material])){
                $change[$item->material] = 100;
            }
        }

        // Set change to -100 if material on past doesn't exists on change
        foreach($pastMaterialOrder as $item){
            if(!isset($change[$item->material])){
                $change[$item->material] = -100;
            }
        }

        arsort($change);
        return $change;
    }

    private function getPopularFurnitures(){
        $furnitures_model = model(FurnitureModel::class);
        $popular_furnitures = $furnitures_model->getPopularFurnitures();

        return $popular_furnitures;
    }

    private function getMostDurableFurnitures(){
        $furnitures_model = model(FurnitureModel::class);
        $reviews_model = model(ReviewModel::class);

        $reviews_recap = $reviews_model->getDurableRecap();
        $result = array();
        foreach($reviews_recap as $recap_data){
            $furniture_data = $furnitures_model->getFurnitureById($recap_data->furniture_id);
            $data = [
                'furniture_name' => $furniture_data[0]->nama,
                'furniture_material' => $furniture_data[0]->jenisMaterial,
                'durability_score' => $recap_data->durability_score_avg
            ];
            array_push($result, $data);
        }
        return $result;
    }
}
