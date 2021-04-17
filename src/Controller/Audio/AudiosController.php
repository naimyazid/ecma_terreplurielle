<?php

namespace App\Controller\Audio;

use App\Entity\Audio;
use App\Repository\AudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @IsGranted("ROLE_USER")
 */
class AudiosController extends AbstractController
{
    /**
     * @Route("/enregistrements-audio", name="app_audios")
     */
    public function Audios(AudioRepository $audioRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        $audios = $paginator->paginate(
            $audioRepository->findByUser($user),
            $request->query->getInt('page',1),
            8
        );
        return $this->render('audio/audios.html.twig', [
            'audios' => $audios,
        ]);
    }

    /**
     * @Route("/audio/{id}/delete", name="app_audio_delete", methods="DELETE")
     */
    public function delete(Audio $audio, Request $request, EntityManagerInterface $manager){
        if($this->isCsrfTokenValid('delete' . $audio->getId(), $request->get('_token'))){
            $manager->remove($audio);
            $manager->flush();
            $this->addFlash('success', 'Enregistremnt audio supprimé avec succès');
        };

        return $this->redirectToRoute('app_audios');

    }

}