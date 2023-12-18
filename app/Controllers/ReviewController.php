<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FurnitureModel;
use App\Models\PesananModel;
use App\Models\ReviewModel;

class ReviewController extends BaseController
{
    public function index()
    {
        //
    }

    public function getReviewByPesananId($id = false){
        $reviewModel = model(ReviewModel::class);
        $review = $reviewModel->getReviewByPesananId($id);

        if ($review){
            return $this->response->setJSON($review[0]);
        }
    }

    public function create(){
        $pesanan_id = $this->request->getPost('pesanan_id');
        $rating = $this->request->getPost('review_score_new');
        $durability = $this->request->getPost('review_durability_new');
        $texture = $this->request->getPost('review_texture_new');
        $maintainability = $this->request->getPost('review_maintainability_new');
        $reviewModel = model(ReviewModel::class);
        $pesananModel = model(PesananModel::class);
        $furniture_id = $pesananModel->find($pesanan_id);
        $furnitureData = model(FurnitureModel::class)->getFurnitureById($furniture_id["furniture_id"]);
        $dataToSave = [
            'jenis_kayu' => $furnitureData[0]->jenisMaterial,
            'merek_kayu' => $furnitureData[0]->merekMaterial,
            'review' => intval($rating),
            'tekstur' => intval($texture),
            'ketahanan' => intval($durability),
            'keperawatan' => intval($maintainability)
        ];
        $this->saveToMaterialAPI(json_encode($dataToSave));
        $reviewModel->createReview($pesanan_id, $furniture_id["furniture_id"], $rating, $durability, $texture, $maintainability);
        return redirect()->to('/pesanan');
    }

    public function update(){
        $pesanan_id = $this->request->getPost('pesanan_id');
        $review_id = model(ReviewModel::class)->getReviewByPesananId($pesanan_id)[0]->id;
        $rating = $this->request->getPost('review_score');
        $durability = $this->request->getPost('review_durability');
        $texture = $this->request->getPost('review_texture');
        $maintainability = $this->request->getPost('review_maintainability');
        $reviewModel = model(ReviewModel::class);
        $reviewModel->update($review_id, [
            'rating' => $rating,
            'durability_score' => $durability,
            'texture_score' => $texture,
            'maintainability_score' => $maintainability
        ]);
        return redirect()->to('/pesanan');
    }

    public function saveToMaterialAPI($data){
        $client = \Config\Services::curlrequest([
            'base_uri' => env('API_URL'),
        ]);
        $body = $data;
        $response = $client->request('POST', '/PenilaianPelanggan/save', [
            'body' => $body,
            'headers' => [
                'Content-Type' => 'application/json'
            ],
        ]);
    }
}
