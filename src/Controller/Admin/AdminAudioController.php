<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Audio;
use App\Repository\AudioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_ADMIN")
 */
class AdminAudioController extends AbstractController
{

    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }


    /**
     * @Route("/admin/{id}/audios", name="admin_audios")
     */
    public function Audios($id, User $user, AudioRepository $audioRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $this->session->remove('userId');
        $this->session->set('userId', $id);
        $audios = $paginator->paginate(
            $audioRepository->findByUser($user),
            $request->query->getInt('page',1),
            10
        );
      
        return $this->render('admin/audio/list_audios.html.twig', [
            'audios' => $audios,
            'user' => $user,
        ]);
    }

    /**
     * @Route("admin/audio/{id}", name="admin_audio")
     */
    public function afficherPhrase(Audio $audio): Response
    {
        return $this->render('admin/audio/spectrogram.html.twig', [
            "audio" => $audio,
            'id' => $this->session->get('userId'),
        ]);
    }

    /**
     * @Route("/admin/audio/{id}/delete", name="admin_audio_delete", methods="DELETE")
     */
    public function delete(Audio $audio, Request $request, EntityManagerInterface $manager){
        if($this->isCsrfTokenValid('delete' . $audio->getId(), $request->get('_token'))){
            $manager->remove($audio);
            $manager->flush();
            $this->addFlash('success', 'Enregistremnt audio supprimé avec succès');
        };

        return $this->redirectToRoute('admin_audios', ['id' => $this->session->get('userId')]);

    }
}