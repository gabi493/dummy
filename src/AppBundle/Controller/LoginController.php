<?php
// src/AppBundle/Controller/LoginController.php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;





class LoginController extends Controller
{

    public function indexAction(Request $request)
    {
        // create a task and give it some dummy data for this example
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('enter', SubmitType::class, array('label' => 'Login'))
            ->add('createUser', SubmitType::class, array('label' => 'New user, here!'))
            ->getForm();

        //authorAction($user);

        $form->handleRequest($request);
        /*return new Response(
            '<html>
                    <body>
                        <pre>' . print_r($form, true) . '</pre>
                    </body>
                </html>'
        );*/

        if ($form->isSubmitted() && $form->isValid()) {
            /*return new Response(
                '<html>
                    <body>
                        <pre>' . print_r($form, true) . '</pre>
                    </body>
                </html>'
            );*/
            // ... perform some action, such as saving the task to the database
            if ($form->get('enter')->isClicked()) {
                return $this->redirectToRoute('login');
            } else if ($form->get('createUser')->isClicked()) {
                /*    $em = $this->getDoctrine()->getManager();
                    $em->persist($form->get('username'));
                    $em->flush();
                */
                return $this->redirectToRoute('newlogin');
            }

        }
        return $this->render('login/form.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function authorAction($user) {
        $user = new User();

        // ... do something to the $user object

        $validator = $this->get('validator');
        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            /*
             * Uses a __toString method on the $errors variable which is a
             * ConstraintViolationList object. This gives us a nice string
             * for debugging.
             */
            $errorsString = (string) $errors;

            /*
             * You could also pass the collection of errors into a template:
             * return $this->render('author/validation.html.twig',
             * array('errors' => $errors,
             * ));
             *
             * */
            return new Response($errorsString);
        }
        return new Response('The author is valid! Yes!');
    }


    /*public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'error_mapping' => array(
                'matchingUsernameAndPassword' => 'username',
            ),
        ));
    }*/


    public function nameAction() {
        $names = array("Raúl", "Jose", "Gabriel", "Araceli", "Aureli");
        $number = rand(0, 100)%5;

        return new Response(
            '<html><body>Lucky team member: '.$names[$number].'</body></html>'
        );
    }


    public function errorAction() {
            return new Response(
                '<html><body>Error (we are talking about your life)</body></html>'
            );
    }


    public function newloginAction(Request $request) {
        $user = new User();
        //$name = $request->get('username');

        $submit = $this->createFormBuilder($user)
            ->add('mail', EmailType::class)
            ->add('username', TextType::class)
            ->add('password', PasswordType::class)
            ->add('rol', TextType::class)
            ->add('createUser', SubmitType::class, array('label' => 'Submit'))
            ->getForm();

        $submit->handleRequest($request);

        if ($submit->isSubmitted() && $submit->isValid() && $submit->isPasswordLegal()) {
            // ... perform some action, such as saving the task to the database
        /*    $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();*/
            return $this->redirectToRoute('submit_successful');
        }

        return $this->render('login/submit.html.twig', array(
            'submit' => $submit->createView(),
        ));

/*        }
        else return new Response(
            '<html><body>_.-·xxXxx·-._</body></html>'
        );
*/    }

    public function isPasswordLegal() {
        return $this->firstName !== $this->password;
    }

    public function submittedAction() {
        return new Response(
            '<html>
                <body>
                    <h1>
                    SUCCESSFULLY SUBMITTED
                    </h1>
                    <h2>Check your e-mail to confirm your login</h2>
                    <h3><a href="/">Go to login page</a></h3>
                </body>
             </html>'
        );
    }
}