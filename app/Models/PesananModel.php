<?php

namespace App\Models;

use CodeIgniter\Model;

class PesananModel extends Model
{
    protected $table            = 'pesanan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['waktuPesanan', 'customer_id', 'kuantitas', 'total_harga', 'furniture_id'];

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

    public function getMaterialOrderSummary(){

        $db = db_connect();
        $builder1 = $db->table('pesanan');
        $builder2 = $db->table('pesanan');
        $builder1->select('furnitures.jenisMaterial as material, COUNT(*) as jumlah')->join('furnitures', 'furnitures.id = pesanan.furniture_id')->groupBy('material')->orderBy('jumlah', 'DESC');
        $builder2->select('furnitures.jenisMaterial as material, COUNT(*) as jumlah')->join('furnitures', 'furnitures.id = pesanan.furniture_id')->groupBy('material')->orderBy('jumlah', 'DESC');
        $queryPast = $builder1->getWhere(['waktuPesanan <' => date('Y-m-d H:i:s', strtotime('-30 days'))]);
        $queryCurrent = $builder2->getWhere(['waktuPesanan >=' => date('Y-m-d H:i:s', strtotime('-30 days'))]);
        $resultPast = $queryPast->getResult();
        $resultCurrent = $queryCurrent->getResult();
        $result = [
            'past' => $resultPast,
            'current' => $resultCurrent
        ];
        return $result;
    }
}
