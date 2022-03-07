<?php

namespace App\Controller;

use App\Form\LoginType;
use App\Form\RoleType;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Classe\Mail;
use App\Classe\Search;
use App\Form\SearchType;
/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
     /**
     * @Route("/listo", name="listo", methods={"GET"})
     */
    public function listo(UserRepository $userRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('user/listo.html.twig', [
            'users' => $userRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        $dompdf->set_option('isRemoteEnabled', true);
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();
        // Store PDF Binary Data
        $output = $dompdf->output();

        // Send some text response

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    }
    /**
     * @Route("/", name="user_index", methods={"GET"})
     *    * @param Request $request
     *   * @param UserRepository $userRepository
     * @return Response
     */
    public function index(UserRepository $userRepository,Request $request)
    {        $users=$userRepository->findAll();

        $search = new Search();

        $form = $this->createForm(SearchType::class, $search);
        $form->handleRequest($request);
        if($form->isSubmitted()&&$form->isValid()){

        $users=$userRepository->findByNom($search);
        }



        return $this->render('user/index.html.twig', [
            'users' => $users,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/Logout", name="Logout")
     */
    public function Logout(Request $request)
    {
        $session = $request->getSession();
        $session->clear();
        return $this->redirectToRoute('front');
    }
    /**
     * @Route("/front", name="front")
     */
    public function Accueil(Request $request)
    {
        return $this->render('/user/accueil.html.twig');
    }
    /**
     * @Route("/login", name="Login")
     */
    public function login(Request $request,UserRepository $repository)
    {
        $user = new User();
        $form=$this->createForm(LoginType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $userCheck = $repository->findOneBy(['email' => $user->getEmail()]);
            if($user->getPassword()==$userCheck->getPassword())
            {
                $session= new Session();
                $session->set('id',$userCheck->getId());
                $session->set('nom',$userCheck->getNom());
                $session->set('mail',$userCheck->getEmail());
                $session->set('image',$userCheck->getImage());
                $session->set('type',$userCheck->getType());
                if($userCheck->getType()=="user")
                return $this->render('/user/accueil.html.twig');
                else
                return $this->redirectToRoute('user_index');
            }
        }
        return $this->render('/user/login.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['image']->getData();
            $filename = md5(uniqid()).'.'.$uploadedFile->guessExtension();
            $uploadedFile->move($this->getParameter('upload_directory'),$filename);
            $user->setImage($filename);
            $user->setType("user");
            $entityManager->persist($user);
            $entityManager->flush();
            
            $nom=$user->getNom();
            $email=$user->getEmail();
            $Mail = new Mail();
            $Mail->send($email,$nom,"bienvenue","Bonjour monsieur $nom votre inscription a eté effectue");
    
        
    
        
            
            return $this->redirectToRoute('Login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RoleType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
   
}
