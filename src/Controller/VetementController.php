<?php
namespace App\Controller;

use App\Entity\Vetement;
use App\Entity\Couleur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\SecurityService;
//use Symfony\Component\Validator\Validator\ValidatorInterface;

class VetementController extends AbstractController {
    /**
     * @Route("/{token}/vetement/insert/{nom}/{idCouleur}", name="Creer_vetement")
     */
    //public function creerVetement(ValidationInterface $validator, EntityManagerInterface $entityManagerInterface, $token, $nom, $idCouleur = 0): Response {
    public function creerVetement(EntityManagerInterface $entityManager, $token, $nom, $idCouleur = 0) {
        //SecurityService $securite;
        $vetement = new Vetement();
        $vetement->setNom($nom);
        if($idCouleur == 0){
            $idCouleur = random_int(1, 4);
        }
        $repCouleur = $this->getDoctrine()->getRepository(Couleur::Class);
        $couleur = $repCouleur->find($idCouleur);// Récupération du dépôt de requete de Couleur
        $vetement->setCouleur($couleur);// Affectation à Vetement
        //$this->validationObjet($validator, $vetement);// Validation des données
        $entityManager->persist($vetement);// On sauvegarde l'objet vetement
        $entityManager->flush();// Execution de la requete
        $response = new Response();// Encodage du vetement en json
        $response->setContent(json_encode([
            'opération'     => 'insert',
            'résultat'      => true,
            'type_objet'    => 'vetement',
            'id_objet'      => $vetement->getId(),
        ]));
        //$response->header->set('Content-Type', 'application/json');
        # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;
        return $response;
    }
/*
    private function validationObjet($validator, vetement $vet){
        if(count($errors) > 0){
            return new Response((string)$errors, 400);
        }
    }
*/
}