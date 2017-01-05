<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gallery;
use AppBundle\Form\GalleryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Config\ConfigCache;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function indexAction()
    {
        $form = $this->createForm(GalleryType::class, new Gallery());

        $images = $this->getDoctrine()
            ->getRepository('AppBundle:Gallery')
            ->findBy(['user' => $this->getUser()]);

        return $this->render(
            'AppBundle:Default:index.html.twig',
            [
                'gallery' => $images,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/upload", name="upload_image")
     */
    public function uploadImageAction(Request $request)
    {
        $gallery = new Gallery();
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $file = $gallery->getFile();
            $fileName = $this->get('app.file_uploader')->upload($file);

            $gallery
                ->setName($fileName)
                ->setUser($this->getUser())
                ->setSize($file->getSize());

            $em->persist($gallery);
            $em->flush();

            $view = $this->renderView('AppBundle:Default:form.html.twig', ['image' => $gallery]);

            return new JsonResponse(['status' => 1, 'html' => $view, 'message' => 'Image was uploaded']);
        }

        $returnMsg = "";
        $errorsIterator = $form->getErrors(true, false);
        foreach ($errorsIterator as $errors) {
            foreach ($errors as $error)
            $returnMsg .= $error->getMessage() . " ";
        }
        return new JsonResponse(['status' => 0, 'message' => $returnMsg]);
    }

    /**
     * @Route("/del/{id}", name="delete_image")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em
            ->getRepository('AppBundle:Gallery')
            ->findOneBy(['id' => $id, 'user' => $this->getUser()]);
        $src = $image->getPath();
        $em->remove($image);
        $em->flush();

        unlink($src);

        return new JsonResponse(['status' => 1, 'message' => "Image was deleted"]);
    }

    /**
     * @Route("/edit/{id}", name="edit_comment")
     */
    public function editAction(Request $request, $id)
    {
        $comment = $request->request->get('comment');
        $em = $this->getDoctrine()->getManager();
        $image = $em
            ->getRepository('AppBundle:Gallery')
            ->findOneBy(['id' => $id, 'user' => $this->getUser()]);
        $image->setComment($comment);
        $em->flush();

        return new JsonResponse(['status' => 1, 'message' => 'Comment was edited']);
    }

    /**
     * @Route("/sort/{sort}/{direction}", name="sort")
     */
    public function sortAction(Request $request, $sort, $direction)
    {
        $gallery = $this->getDoctrine()->getRepository(Gallery::class)->findBy(['user' => $this->getUser()], [$sort => $direction]);
        $view = "";
        foreach ($gallery as $image) {
            $view .= $this->renderView('AppBundle:Default:form.html.twig', ['image' => $image]);
        }

        return new JsonResponse(['status' => 1, 'html' => $view]);
    }
}
