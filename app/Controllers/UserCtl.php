<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use App\Models\User;
use App\Models\Maladie;
use App\Models\Recette;
use App\Models\Aliment;
use CodeIgniter\RESTful\ResourceController;
use Exception;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class UserCtl extends ResourceController
{
    use ResponseTrait;

    private function getKey(): string
    {
        return "SickCare_Application";
    }

    public function register()
    {
        $rules = [
            "email" => "required|valid_email|is_unique[users.email]|min_length[6]",
            "nom" => "required|min_length[2]",
            "prenom" => "required|min_length[2]",
            "maladie" => "required",
            'mot_de_passe' => 'required|min_length[4]|max_length[100]',
            'confirmpassword' => 'required|matches[mot_de_passe]'
        ];

        $messages = [
            "email" => [
                "required" => "L'email est requis",
                "valid_email" => "L'email n'est pas dans le bon format",
                "is_unique" => "Cet email est déjà utilisé",
                "min_length" => "L'email doit comporter au moins 6 caractères"
            ],
            "mot_de_passe" => [
                "required" => "Le mot de passe est requis",
                "min_length" => "Le mot de passe doit comporter au moins 6 caractères"
            ],
            "confirmpassword" => [
                "required" => "La confirmation du mot de passe est requise",
                "matches" => "Les mots de passe ne correspondent pas"
            ],
            "nom" => [
                "required" => "Le nom est requis",
                "min_length" => "Le nom doit comporter au moins 2 caractères"
            ],
            "prenom" => [
                "required" => "Le prénom est requis",
                "min_length" => "Le prénom doit comporter au moins 2 caractères"
            ],
            "maladie" => [
                "required" => "La maladie est requise"
            ]
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        try {
            $user = new User();
            $user->nom = $this->request->getVar('nom');
            $user->prenom = $this->request->getVar('prenom');
            $user->email = $this->request->getVar('email');
            $user->mot_de_passe = password_hash($this->request->getVar('mot_de_passe'), PASSWORD_DEFAULT);
            
            if (!$user->save()) {
                throw new Exception('Failed to save user');
            }

            $maladieName = $this->request->getVar('maladie');
            $maladie = Maladie::firstOrCreate(['nom' => $maladieName]);
            $user->maladies()->attach($maladie->id_maladie);

            return $this->respondCreated([
                'status' => 201,
                'error' => false,
                'message' => 'Utilisateur enregistré avec succès',
                'data' => [
                    'id_compte' => $user->id_compte
                ]
            ]);

        } catch (Exception $e) {
            log_message('error', 'Registration error: ' . $e->getMessage());
            return $this->failServerError('Erreur lors de l\'enregistrement: ' . $e->getMessage());
        }
    }

    public function login()
    {
        $rules = [
            "email" => "required|valid_email|min_length[6]",
            "mot_de_passe" => "required",
        ];

        $messages = [
            "email" => [
                "required" => "Email requis",
                "valid_email" => "Format d'email invalide"
            ],
            "mot_de_passe" => [
                "required" => "Mot de passe requis"
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $email = $this->request->getVar("email");
        $user = User::where("email", $email)->first();

        if (!$user) {
            return $this->failNotFound('Email non trouvé');
        }

        if (!password_verify($this->request->getVar("mot_de_passe"), $user->mot_de_passe)) {
            return $this->failUnauthorized('Mot de passe incorrect');
        }

        $key = $this->getKey();
        $now = time();

        $payload = [
            "iss" => "SickCare_Issuer",
            "aud" => "SickCare_Audience",
            "iat" => $now,
            "nbf" => $now + 10,
            "exp" => $now + 3600,
            "data" => [
                'id_compte' => $user->id_compte,
                'email' => $user->email
            ]
        ];

        try {
            $token = JWT::encode($payload, $key, "HS256");
            
            return $this->respond([
                'status' => 200,
                'error' => false,
                'message' => 'Connexion réussie',
                'data' => [
                    'token' => $token,
                    'expires_in' => 3600
                ]
            ]);
            
        } catch (Exception $e) {
            log_message('error', 'Token generation error: ' . $e->getMessage());
            return $this->failServerError('Erreur lors de la génération du token');
        }
    }

    public function details()
{
    try {
        $key = $this->getKey();
        $authHeader = $this->request->getHeader("Authorization");

        if (is_null($authHeader)) {
            throw new Exception('Authorization header is missing');
        }

        $authHeader = $authHeader->getValue();
        $token = str_replace("Bearer ", "", $authHeader);  // Enlever "Bearer " du token
        
        JWT::$leeway = 60; // Leeway pour le token
        $decoded = JWT::decode($token, new Key($key, 'HS256'));

        if ($decoded) {
            // Récupérer les informations de l'utilisateur avec les maladies et les aliments
            $user = User::with(['maladies', 'maladies.aliments'])->find($decoded->data->id_compte);

            // Récupérer toutes les recettes disponibles sans filtrage
            $recettes = Recette::with('aliments')->get();  // On récupère toutes les recettes avec les aliments associés

            // Formater la réponse avec les données de l'utilisateur et les recettes
            $response = [
                'status' => 200,
                'error' => false,
                'message' => 'User details',
                'data' => [
                    'profile' => $decoded,
                    'user_data' => $user,
                    'recettes' => $recettes  // Ajouter les recettes sans les filtrer
                ]
            ];
            return $this->respond($response);
        }

    } catch (Exception $ex) {
        $response = [
            'status' => 401,
            'error' => true,
            'message' => 'Access denied with dbg:' . $authHeader . ' ' . $ex->getMessage(),
            'data' => []
        ];
        return $this->fail($response, 401);
    }
}







    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        service('eloquent');
    }
}