<?php
namespace App\Controller;

use App\Entity\suspect;
use App\Entity\Couleur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\SecurityService;
//use Symfony\Component\Validator\Validator\ValidatorInterface;

class suspectController extends AbstractController {
    /**
     * @Route("/{token}/suspect/{id}")
     */
    //public function creersuspect(ValidationInterface $validator, EntityManagerInterface $entityManagerInterface, $token, $nom, $idCouleur = 0): Response {
    public function findsuspect(EntityManagerInterface $entityManager, $token, $nom, $idCouleur = 0) {
        //SecurityService $securite;
        $suspect = new suspect();
        $suspect->setNom($nom);
        if($idCouleur == 0){
            $idCouleur = random_int(1, 4);
        }
        $repCouleur = $this->getDoctrine()->getRepository(Couleur::Class);
        $couleur = $repCouleur->find($idCouleur);// Récupération du dépôt de requete de Couleur
        $suspect->setCouleur($couleur);// Affectation à suspect
        //$this->validationObjet($validator, $suspect);// Validation des données
        $entityManager->persist($suspect);// On sauvegarde l'objet suspect
        $entityManager->flush();// Execution de la requete
        $response = new Response();// Encodage du suspect en json
        $response->setContent(json_encode([
            'opération'     => 'insert',
            'résultat'      => true,
            'type_objet'    => 'suspect',
            'id_objet'      => $suspect->getId(),
        ]));
        # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;
        return $response;
    }
}