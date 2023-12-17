<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\FurnitureModel;
use App\Models\PesananModel;
use App\Models\ReviewModel;

class PesananController extends BaseController
{
    public function index()
    {
        $session = session();

        // Show all users order
        $reviewModel = model(ReviewModel::class);
        $pesananModel = model(PesananModel::class);
        $furnitureModel = model(FurnitureModel::class);

        $data['pesanans'] = $pesananModel->where('customer_id', $session->get('user_id'))->orderBy('waktuPesanan', 'DESC')->findAll();
        foreach ($data['pesanans'] as $key => $value) {
            $isOrderReviewed = $reviewModel->where('pesanan_id', $value['id'])->first();
            if($isOrderReviewed){
                $data['pesanans'][$key]['isReviewed'] = true;
                $data['pesanans'][$key]['review_score'] = $isOrderReviewed['rating'];
            } else {
                $data['pesanans'][$key]['isReviewed'] = false;
                $data['pesanans'][$key]['review_score'] = null;
            }
            $data['pesanans'][$key]['furniture_name'] = ($furnitureModel->find($value['furniture_id']))->nama;
        }
        return(view('pesanan/index', $data));
    }

    public function create() {
        $session = session();

        // Create new order
        $furniture_id = $this->request->getPost('furniture_id');
        $quantity = $this->request->getPost('qty');
        $total_price = $this->request->getPost('price');
        // Data
        $data = [
            'waktuPesanan' => date('Y-m-d H:i:s'),
            'customer_id' => $session->get('user_id'),
            'kuantitas' => $quantity,
            'total_harga' => $total_price,
            'furniture_id' => $furniture_id
        ];

        $pesananModel = model(PesananModel::class);
        $furnitureModel = model(FurnitureModel::class);
        $isInserted = $pesananModel->insert($data);

        if ($isInserted) {
            $isUpdated = $furnitureModel->update($furniture_id, ['stok' => $furnitureModel->find($furniture_id)->stok - $quantity]);
            if ($isUpdated){
                return redirect()->to('/pesanan');
            }
        }

    }
}
