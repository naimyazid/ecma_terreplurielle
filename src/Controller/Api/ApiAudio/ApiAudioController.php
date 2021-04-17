<?php

namespace App\Controller\Api\ApiAudio;

use App\Entity\Audio;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ApiAudioController extends AbstractController
{
  /**
    * @Route("/api/audio", name="api_audio", methods={"POST"})
    * @param Request $request
    * @param EntityManagerInterface $em
    * @return Response
    */
  public function index(Request $request, EntityManagerInterface $em): Response
  {
      // Ajouter le try and catch
      // Ajouter la validation des données avec le Validator côté des entités
      // Ajouter les données de l'utilisateur

      $user = $this->getUser();
      $file = $request->files->get('file');

      $audioFile = md5(uniqid()).'.'.$file->guessExtension();

      $file->move(
          $this->getParameter('audio_directory'),
          $audioFile
      );

      $audio = new Audio();
      $audio->setUser($user);
      $audio->setName($audioFile);

      $em->persist($audio);
      $em->flush();

      return $this->json($audio, 201, [], ['groups'=>'audio:read']);

 }
}