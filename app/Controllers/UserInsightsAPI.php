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
        // API Authentication
        $isAuthenticated = $this->authenticateAPIAccess($this->request);
        
        if (!$isAuthenticated) {
            return $this->respond(['message' => 'Unauthorized access', 'data' => null], 401, 'Unauthorized access');
        }
        // Get 3 most popular furniture items based on the number of orders
        $data['most_popular_furnitures'] = $this->getPopularFurnitures();

        // Get trending materials based on orders 2 30-days period (-60 to -30 and -30 to current day)
        $data['materials_demand_increase_percentage'] = $this->getTrendingMaterial();

        // Get material recap
        $material_recap = $this->getListMaterialScore();

        // Get most durable material
        $data['most_durable_material_list'] = $material_recap['durabilityList'];

        // Get most best texture material
        $data['best_texture_material_list'] = $material_recap['textureList'];
        // Get most maintainable material
        $data['best_maintanability_material_list'] = $material_recap['maintainabilityList'];
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

    private function getMaterialReviewRecap(){
        $review_model = model(ReviewModel::class);
        $furniture_model = model(FurnitureModel::class);
        // Group by furniture_id
        $review_data = $review_model->getMaterialData();
        foreach($review_data as $data){
            $furniture_data = $furniture_model->getFurnitureById($data->furniture_id);
            $data->material_name = $furniture_data[0]->jenisMaterial;
            $data->material_brand = $furniture_data[0]->merekMaterial;
        }
        return $review_data;
    }

    private function getListMaterialScore(){
        $material_recap = $this->getMaterialReviewRecap();
        $result_durability = array();
        $result_texture = array();
        $result_maintainability = array();
        foreach($material_recap as $recap_data){
            $data1 = [
                'material_name' => $recap_data->material_name,
                'material_brand' => $recap_data->material_brand,
                'durability_score' => number_format($recap_data->avg_durability_score, 2)
            ];
            $data2 = [
                'material_name' => $recap_data->material_name,
                'material_brand' => $recap_data->material_brand,
                'texture_score' => number_format($recap_data->avg_texture_score, 2)
            ];
            $data3 = [
                'material_name' => $recap_data->material_name,
                'material_brand' => $recap_data->material_brand,
                'maintainability_score' => number_format($recap_data->avg_maintainability_score, 2)
            ];
            array_push($result_durability, $data1);
            array_push($result_texture, $data2);
            array_push($result_maintainability, $data3);
        }
        usort($result_durability, function($a, $b){
            return $a['durability_score'] < $b['durability_score'];
        });
        usort($result_texture, function($a, $b){
            return $a['texture_score'] < $b['texture_score'];
        });
        usort($result_maintainability, function($a, $b){
            return $a['maintainability_score'] < $b['maintainability_score'];
        });
        $result_array = [
            'durabilityList' => $result_durability,
            'textureList' => $result_texture,
            'maintainabilityList' => $result_maintainability
        ];
        return $result_array;
    }

    public function authenticateAPIAccess($request){
        $api_username = $request->getGet('username');
        $password = $request->getGet('password');
        if($api_username == env('API_USERNAME') && $password == env('API_PASSWORD')){
            return true;
        } else {
            return false;
        }
    }
    
}