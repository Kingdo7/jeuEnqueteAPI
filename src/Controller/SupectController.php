<?php

namespace App\Controller;

use App\Entity\Suspect;
use App\Services\SecurityService;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class SupectController extends AbstractController {
    /**
     * @Route("{token}/suspect", name="Suspects")
     */
    public function findAll(EntityManagerInterface $entityManager, SecurityService $securite, $token) {
        // vérification de l'accès
        $autorise = $securite->CheckToken($token);

        if(!is_bool($autorise)) {
            return $autorise;
        }

        // Récupération des suspect
        $repSuspect = $this->getDoctrine()->getRepository(Suspect::Class);
        $listSuspect = $repSuspect->findAll();     

        // dd($listSuspect);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);        
        $jsonContent = $serializer->serialize($listSuspect, 'json');            

        // Encodage des suspects en json
        $response = new Response();
        $response->setContent($jsonContent);

        $response->headers->set('Content-Type', 'application/json');
        # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;            

       return $response;
    }

    /**
     * @Route("{token}/suspect/{id}", name="Suspect")
     */
    public function find(EntityManagerInterface $entityManager, SecurityService $securite, $token, $id){

        // vérification de l'accès
        $autorise = $securite->CheckToken($token);

        if(!is_bool($autorise)) {
            return $autorise;
        }

        // Récupération du dépôt de requete de Couleur
        $repSuspect = $this->getDoctrine()->getRepository(Suspect::Class);
        $listSuspect = $repSuspect->find($id);  

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);        
        $jsonContent = $serializer->serialize($listSuspect, 'json');        

       // Encodage du vetement en json
       $response = new Response();
       $response->setContent($jsonContent);

       $response->headers->set('Content-Type', 'application/json');
       # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;

       return $response;
    }

     /**
     * @Route("{token}/suspects/genre/{genre}/age/{age}", name="SuspectByAgeGenre")
     */
    public function findByGenreAge(EntityManagerInterface $entityManager, $genre, $age){
        // Récupération du dépôt de requete de Couleur
        $repSuspect = $this->getDoctrine()->getRepository(Suspect::Class);
        $listSuspect = $repSuspect->findByGenreAgeSup($genre, $age); 
       
        // dd($listSuspect);
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);        
        $jsonContent = $serializer->serialize($listSuspect, 'json');        

       // Encodage du vetement en json
       $response = new Response();
       $response->setContent($jsonContent);

       $response->headers->set('Content-Type', 'application/json');
       # voir aussi use Symfony\Component\HttpFoundation\JsonResponse;

       return $response;
    }
}
