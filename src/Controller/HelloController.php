<?php
namespace App\Controller;

use App\Entity\Produto;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HelloController extends AbstractController
{
    /**
     * @return Response
     *
     * @Route("hello_world")
     *
     */
    public function world()
    {
        return new Response(
            '<html><body><h1>Hello world!</h1></body></html>'
        );
    }

    /**
     * @return Response
     *
     * @Route("mostrar-mensagem")
     */
    public function mensagem()
    {
        return $this->render("hello/mensagem.html.twig", [
            'mensagem' => 'que loco'
        ]);
    }

    /**
     * @return Response
     *
     * @Route("cadastrar-produto")
     *
     */
    public function produto()
    {
        $em = $this->getDoctrine()->getManager();

        $produto = new Produto();
        $produto->setNome("Xbox");
        $produto->setPreco(3000);
        $produto->setDescricao("Novo 500GB 2 controles");

        $em->persist($produto);
        $em->flush();

        return new Response("O produto " . $produto->getId() . "foi criado!");


    }

    /**
     * @return Response
     *
     * @Route("formulario")
     */
    public function formulario(Request $request)
    {
        $produto = new Produto();

        $form = $this->createFormBuilder($produto)
            ->add('nome', TextType::class)
            ->add('preco', IntegerType::class)
            ->add('descricao', TextType::class)
            ->add('Enviar', SubmitType::class, ['label' => "Salvar"])
            ->getForm();

        $form->handleRequest($request);

        return $this->render("hello/formulario.html.twig", [
            'form' => $form->createView()
        ]);


    }

}