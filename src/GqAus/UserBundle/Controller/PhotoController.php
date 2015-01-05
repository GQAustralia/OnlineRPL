<?php

namespace GqAus\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use GqAus\UserBundle\Form\PhotoType;

class PhotoController extends Controller
{
    public function addAction(Request $request)
    {
        $form = $this->createForm(new PhotoType(), array());

        if ($request->isMethod('POST')) {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $form->getData();
                $url = $this->getPhotoUploader()->upload($data['photo']);

                return; // display a response or redirect
            }
        }

        return $this->render(
            'GqAusUserBundle:Photo:add.html.twig',
            array('form'  => $form->createView())
        );
    }

    /**
     * @return Acme\StorageBundle\Uploader\PhotoUploader
     */
    protected function getPhotoUploader()
    {
        return $this->get('gq_aus_user.photo_uploader');
    }
}