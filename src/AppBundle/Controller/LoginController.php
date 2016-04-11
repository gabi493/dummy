<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class LoginController extends Controller
{
//    public function indexAction() {
        /*return new Response(
            http_redirect("http://localhost:8000/login")
        );*/

        /*$number = rand(0, 6);

        if ($number % 2) {*/
            //return $this->redirect($this->generateUrl('login'));
//            return $this->render(
//                'login/form.html.twig'
//            );
        /*}
        else {
            return $this->redirect($this->generateUrl('xlogin'));
        }*/
//    }

    public function indexAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('save', SubmitType::class, array('label' => 'Login'))
            ->add('createUser', SubmitType::class, array('label' => 'Create new user'))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... perform some action, such as saving the task to the database
            if ($form->get('save')->isClicked()) {
                return $this->redirectToRoute('login');
            }
            else if ($form->get('createUser')->isClicked()) {
                return $this->redirectToRoute('xlogin');
            }

        }


        return $this->render('login/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_mapping' => array(
                'matchingUsernameAndPassword' => 'username',
            ),
        ));
    }

    public function nameAction()
    {
        $names = array("Raúl", "Jose", "Gabriel", "Araceli", "Aureli");
        $number = rand(0, 100)%5;

        return new Response(
            '<html><body>Lucky team member: '.$names[$number].'</body></html>'
        );
    }

    public function errorAction()
        {
            return new Response(
                '<html><body>Error (we are talking about your life)</body></html>'
            );
        }
    public function xloginAction()
    {
        return new Response(
            '<html><body>_.-·xxXxx·-._</body></html>'
        );
    }
}