<?php
namespace App\Controllers;

use App\Models\Recette;
use App\Models\Aliment;
use CodeIgniter\API\ResponseTrait;


class WebServiceControlleur extends BaseController {
    use ResponseTrait;

    public function getRecette() {
        $son = Recette::all();
        return $this->respond($son);
    }

    }
