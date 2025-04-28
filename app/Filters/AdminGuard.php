<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminGuard implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Vérifie si l'utilisateur est connecté
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/connexion');
        }

        // Vérifie si l'utilisateur est admin
        if (session()->get('id_compte') !== 1) {
            // Si ce n'est pas l'admin, on peut le rediriger ailleurs (par exemple page d'accueil)
            return redirect()->to('/sickcares');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Rien ici pour l'instant
    }
}
