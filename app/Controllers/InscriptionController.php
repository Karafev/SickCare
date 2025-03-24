<?php
namespace App\Controllers;
use App\Models\User;
class InscriptionController extends BaseController
{
    public function index()
    {
        helper(['form']);
        $data = [];
        echo view('inscription', $data);
    }
    public function traiteInscription()
        {
        helper(['form']);
        $rules = [
                'email' => 'required|min_length[2]|max_length[50]|valid_email|is_unique[users.email]',
                'nom' => 'required|min_length[2]|max_length[50]',
                'prenom' => 'required|min_length[2]|max_length[50]',
                'mot_de_passe' => 'required|min_length[4]|max_length[100]|',
                'confirmpassword' => 'matches[mot_de_passe]']
                ;
        if($this->validate($rules)){
            $user=new User();
            $user->nom = $this->request->getVar('nom');
            $user->prenom = $this->request->getVar('prenom');
            $user->email = $this->request->getVar('email');
            $user->mot_de_passe = password_hash($this->request->getVar('mot_de_passe'),PASSWORD_DEFAULT) ;
            $user->save();
            return redirect()->to('/connexion');
        }else{
            $data['validation'] = $this->validator;
            echo view('inscription', $data);
        }
    }
}