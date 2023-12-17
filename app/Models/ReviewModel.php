<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['rating', 'durability_score', 'texture_score', 'maintainability_score'];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getDurableRecap(){
        $db = db_connect();
        $result = $db->table('reviews')->select('furniture_id, AVG(durability_score) as durability_score_avg')->groupBy('furniture_id')->orderBy('durability_score_avg', 'DESC')->get()->getResult();
        foreach($result as $data){
            $data->durability_score_avg = number_format($data->durability_score_avg, 2);
        }
        return $result;
    }

    public function getMaterialData(){
        $db = db_connect();
        $res = $db->table('reviews')->select('furniture_id, AVG(rating) as avg_rating, AVG(durability_score) as avg_durability_score, AVG(texture_score) as avg_texture_score, AVG(maintainability_score) as avg_maintainability_score')->groupBy('furniture_id')->get()->getResult(); 
        return $res;
    }

    public function getRatingGroups($furniture_id){
        $db = db_connect();
        $res = $db->table('reviews')->select('rating')->where('furniture_id', $furniture_id)->get()->getResult();
        $data = [
            '0 - 1' => 0,
            '1 - 2' => 0,
            '2 - 3' => 0,
            '3 - 4' => 0,
            '4 - 5' => 0
        ];
        foreach($res as $review_item){
            if($review_item->rating >= 0 && $review_item->rating <= 1){
                $data['0 - 1']++;
            } else if($review_item->rating >= 1 && $review_item->rating <= 2){
                $data['1 - 2']++;
            } else if($review_item->rating >= 2 && $review_item->rating <= 3){
                $data['2 - 3']++;
            } else if($review_item->rating >= 3 && $review_item->rating <= 4){
                $data['3 - 4']++;
            } else if($review_item->rating >= 4 && $review_item->rating <= 5){
                $data['4 - 5']++;
            }
        }
        return $data;
    }

    public function createReview($pesanan_id, $furniture_id, $rating, $durability_score, $texture_score, $maintainability_score){
        $db = db_connect();
        $data = [
            'pesanan_id' => $pesanan_id,
            'furniture_id' => $furniture_id,
            'rating' => $rating,
            'durability_score' => $durability_score,
            'texture_score' => $texture_score,
            'maintainability_score' => $maintainability_score,
            'date_created' => date('Y-m-d H:i:s')
        ];
        $db->table('reviews')->insert($data);
    }

    public function getAverageRating($furniture_id){
        $db = db_connect();
        $res = $db->table('reviews')->selectAvg('rating')->where('furniture_id', $furniture_id)->get()->getRow()->rating;
        $res = floatval(number_format($res,2));
        return $res;
    }

    public function getReviewByPesananId($id){
        $db = db_connect();
        $res = $db->table('reviews')->where('pesanan_id', $id)->get()->getResult();
        return $res;
    }
}
