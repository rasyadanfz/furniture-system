<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FurnitureModel;
use App\Models\ReviewModel;
use CodeIgniter\Entity\Cast\FloatCast;

class FurnitureController extends BaseController
{
    public function index()
    {
        $this->updateRating();
        $model = model(FurnitureModel::class);
        $data['furnitures'] = $model->findAll();

        return view('furniture/index', $data);
    }

    public function detail($seg1 = false){
        $model = model(FurnitureModel::class);
        $data['furnitures'] = $model->find($seg1);
        $data['review_group'] = model(ReviewModel::class)->getRatingGroups($seg1);
        return view('furniture/detail', $data);
    }

    public function search(){
        $durability_score = $this->request->getGet('durability');
        $texture_score = $this->request->getGet('texture');
        $maintainability_score = $this->request->getGet('maintainability');
        $data = [
            'tingkatTekstur' => $durability_score,
            'tingkatKeperawatan' => $texture_score,
            'tingkatKetahanan' => $maintainability_score
        ];
        // Contact material API for recommendation
        $client = \Config\Services::curlrequest([
            'base_uri' => 'http://localhost:8080/',
        ]);
        $toSend = [
            $data, 'username' => 'furniture-system-access-user', 'password' => 'furniture-password-J2hgPoj&7xW2Tyu'
        ];
        $body = json_encode($toSend);
        $response = $client->request('POST', '/api/rekomendasi/cari', [
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);
        $response = json_decode($response->getBody());
        if ($response->status == false){
            return redirect()->to('/');
        } else {
            $topScores = [];
            $data = $response->data;
            foreach($data as $key => $rekomendasiRow){
                $calculateDiff = abs($rekomendasiRow->Tingkat_Tekstur - $texture_score) + abs($rekomendasiRow->Tingkat_Keperawatan - $maintainability_score) + abs($rekomendasiRow->Tingkat_Ketahanan - $durability_score);
            
                // If there are less than 3 top scores, or the current score is greater than the smallest score in the top scores
                if (count($topScores) < 3 || $calculateDiff < min(array_column($topScores, 'score'))){
                    // If there are already 3 top scores, remove the smallest score
                    if (count($topScores) == 3){
                        $minIndex = array_search(min(array_column($topScores, 'score')), array_column($topScores, 'score'));
                        unset($topScores[$minIndex]);
                        $topScores = array_values($topScores);
                    }
            
                    // Add the current score, ID, jenis_kayu, and merek_kayu to the top scores array
                    $topScores[] = [
                        'score' => $calculateDiff,
                        'id' => $rekomendasiRow->id,
                        'jenis_kayu' => $rekomendasiRow->Jenis_Kayu,
                        'merek_kayu' => $rekomendasiRow->Merek_Kayu
                    ];
                }
            }
    
            $furnitureModel = model(FurnitureModel::class);
            $result = [];
            foreach($topScores as $key => $material){
                $jenis = $material["jenis_kayu"];
                $merek = $material["merek_kayu"];
    
                $jenisFurnitureList = $furnitureModel->getFurnitureByJenis($jenis);
                $merekFurnitureList = $furnitureModel->getFurnitureByMerek($merek);
    
                if(count($jenisFurnitureList) == 0 || count($merekFurnitureList) == 0){
                    continue;
                } 
    
                $furnitureByJenis = json_decode(json_encode($furnitureModel->getFurnitureByJenis($jenis)[0]), true);
                $furnitureByMerek = json_decode(json_encode($furnitureModel->getFurnitureByMerek($merek)[0]), true);
    
                // Find the one that are both in those arrays
                $isCommonFurniture = $furnitureByJenis["id"] == $furnitureByMerek["id"];
                // If there are none, select one randomly from jenis
                if(!$isCommonFurniture){
                    array_push($result, json_decode(json_encode($furnitureByJenis)));
                } else {
                    $commonFurniture = $furnitureModel->find($furnitureByJenis["id"]);
                    array_push($result, (json_decode(json_encode($commonFurniture))));
                }
            }
            return view('/furniture/index', ['furnitures' => $result]);
        }
    }

    private function updateRating(){
        $model = model(FurnitureModel::class);
        $allFurniture = $model->findAll();
        foreach ($allFurniture as $key => $value) {
            // Calculate avg rating for this furniture
            $review_model = model(ReviewModel::class);
            $res = $review_model->getAverageRating($value->id);
            $model->update($value->id, [
                'rating' => $res  
            ]);
        }
    }
}
