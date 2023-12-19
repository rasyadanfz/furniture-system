<?php

namespace App\Models;

use CodeIgniter\Model;

class FurnitureModel extends Model
{
    protected $table            = 'furnitures';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['stok', 'rating'];


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

    public function getPopularFurnitures(){
        $db = db_connect();

        $builder = $db->table('furnitures');
        $builder->select('nama, COUNT(*) as order_count')
                ->join('pesanan', 'furnitures.id = pesanan.furniture_id')
                ->groupBy('furniture_id')
                ->orderBy('order_count', 'DESC')
                ->limit(3);

        return $builder->get()->getResult();
    }

    public function getFurnitureById($id){
        $db = db_connect();
        $builder = $db->table('furnitures')->select('*')->where('id', $id);
        return $builder->get()->getResult();
    }

    public function getFurnitureByJenis($jenis){
        $db = db_connect();
        $builder = $db->table('furnitures')->select('*')->where('jenisMaterial', $jenis);
        return $builder->get()->getResult();
    }

    public function getFurnitureByMerek($merek){
        $db = db_connect();
        $builder = $db->table('furnitures')->select('*')->where('merekMaterial', $merek);
        return $builder->get()->getResult();
    }
}
