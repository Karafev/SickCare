<?php
namespace App\Controllers;
use App\Models\User;
class Users extends BaseController {   

    public function index() {
        $data['users'] = User::all();
        $data['title'] = "Liste des Utilisateurs";
        
        echo view('sickcares/templates/header', $data);
        echo view('sickcares/utilisateurs', $data);
        echo view('sickcares/templates/footer');
    }


    public function delete($id_compte) {
        $model= new User();
        $model->where('id_compte',$id_compte)->delete();
        return redirect()->to('/utilisateurs');
        
        
    }
}
