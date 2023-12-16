<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FurnitureModel;

class FurnitureController extends BaseController
{
    public function index()
    {
        $kebutuhan = $this->request->getPost('dropdown');

        $model = model(FurnitureModel::class);
        helper('form');
        if ($kebutuhan == 'Tidak ada' || !$kebutuhan){
            $data['furnitures'] = $model->findAll();
        }
        elseif($kebutuhan == 'Tahan Lama'){
            // Implement material filtering based on Material System API, use getMaterialForKebutuhan
            // $data['furnitures'] = $model->where('kebutuhan', 'Tahan Lama')->findAll();
        }elseif($kebutuhan == 'Cost-Effective'){
            // Implement material filtering based on Material System API, use getMaterialForKebutuhan
            // $data['furnitures'] = $model->where('kebutuhan', 'Cost-Effective')->findAll();
        }
        $data['options'] = ['Tidak ada','Tahan Lama', 'Cost-Effective'];
        return view('furniture/index', $data);
    }

    public function detail($seg1 = false){
        $model = model(FurnitureModel::class);
        $data['furnitures'] = $model->find($seg1);
        return view('furniture/detail', $data);
    }

    public function search(){
        $durability_score = $this->request->getGet('durability');
        $texture_score = $this->request->getGet('texture');
        $maintainability_score = $this->request->getGet('maintainability');
        // Contact material API for recommendation
    }

    private function getMaterialForKebutuhan(string $kebutuhan){
        // Call other API
    }
}
