<?php
namespace App\Controllers;
use CodeIgniter\Controller;
class ProfileController extends Controller
{
public function index()
{
$session = session();
echo "Hello : ".$session->get('nom');
echo "Hello : ".$session->get('maladie');

}
}