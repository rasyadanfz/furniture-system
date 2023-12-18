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
        $body = json_encode($data);
        $response = $client->request('POST', '/api/rekomendasi/cari', [
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);
        dd($response);
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
