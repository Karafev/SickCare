<?php
namespace App\Controllers;
use App\Models\User;

class ConnexionController extends BaseController
{
    public function index()
    {
        helper(['form']);
        echo view('connexion');
    }

    public function traiteConnexion()
    {
        $session = session();
        $email_utilisateur = $this->request->getVar('email');
        $mot_de_passe_utilisateur = $this->request->getVar('mot_de_passe');

        // Fetch the user by email
        $user = User::where('email', $email_utilisateur)->first();
        
        if ($user) {
            // Verify the password
            $pass = $user->mot_de_passe;
            $authenticatePassword = password_verify($mot_de_passe_utilisateur, $pass);

            if ($authenticatePassword) {
                // Set session data
                $ses_data = [
                    'id_utilisateur' => $user->id_compte,
                    'nom' => $user->nom,
                    'prenom' => $user->prenom,
                    'email' => $user->email,
                    'isLoggedIn' => TRUE
                ];
                
                $session->set($ses_data);

                // Redirect to user-specific page
                return redirect()->to('/sickcares');
            } else {
                // Invalid password
                $session->setFlashdata('msg', 'Incorrect password.');
                return redirect()->to('/connexion');
            }
        } else {
            // User not found
            $session->setFlashdata('msg', 'Email does not exist.');
            return redirect()->to('/connexion');
        }
    }
}
