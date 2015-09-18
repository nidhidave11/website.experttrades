<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class HomepageController extends SecurityController
{
    /**
     * @Route("/api/v1/homepage", name="get_homepage")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $website =  $em->getRepository('AppBundle\Entity\Website')->find(1);

        $this->checkAccess($request);

        $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);

        $slidersArray = [];
        foreach($homepage->getSliders() as $slider){
            $slidersArray[] = [
              'title' => $slider->getTitle(),
              'subtitle' => $slider->getSubtitle(),
              'button_text' => $slider->getButtonText()
            ];
        }

        $response = new Response(json_encode(
        [
          'about_us_title' => $homepage->getAboutUsTitle(),
          'about_us_text' => $homepage->getAboutUsText(),

          'about_us_first_point_title' => $homepage->getAboutUsFirstPointTitle(),
          'about_us_first_point_text' => $homepage->getAboutUsFirstPointText(),
          'about_us_first_point_image' => $homepage->getAboutUsFirstPointImage(),

          'about_us_second_point_title' => $homepage->getAboutUsSecondPointTitle(),
          'about_us_second_point_text' => $homepage->getAboutUsSecondPointText(),
          'about_us_second_point_image' => $homepage->getAboutUsSecondPointImage(),

          'about_us_third_point_title' => $homepage->getAboutUsThirdPointTitle(),
          'about_us_third_point_text' => $homepage->getAboutUsThirdPointText(),
          'about_us_third_point_image' => $homepage->getAboutUsThirdPointImage(),

          'sliders' => $slidersArray
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/homepage", name="post_homepage")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $em = $this->getDoctrine()->getManager();
         $homepage =  $em->getRepository('AppBundle\Entity\Homepage\Homepage')->find(1);

         $this->checkAccess($request);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['about_us_title'])){
               $homepage->setAboutUsTitle($params['about_us_title']);
             }
             if(isset($params['about_us_text'])){
               $homepage->setAboutUsText($params['about_us_text']);
             }

             if(isset($params['about_us_first_point_title'])){
               $homepage->setAboutUsFirstPointTitle($params['about_us_first_point_title']);
             }
             if(isset($params['about_us_first_point_text'])){
               $homepage->setAboutUsFirstPointText($params['about_us_first_point_text']);
             }
             if(isset($params['about_us_first_point_image'])){
               $homepage->setAboutUsFirstPointImage($params['about_us_first_point_image']);
             }

             if(isset($params['about_us_second_point_title'])){
               $homepage->setAboutUsSecondPointTitle($params['about_us_second_point_title']);
             }
             if(isset($params['about_us_second_point_text'])){
               $homepage->setAboutUsSecondPointText($params['about_us_second_point_text']);
             }
             if(isset($params['about_us_second_point_image'])){
               $homepage->setAboutUsSecondPointImage($params['about_us_second_point_image']);
             }

             if(isset($params['about_us_third_point_title'])){
               $homepage->setAboutUsThirdPointTitle($params['about_us_third_point_title']);
             }
             if(isset($params['about_us_third_point_text'])){
               $homepage->setAboutUsThirdPointText($params['about_us_third_point_text']);
             }
             if(isset($params['about_us_third_point_image'])){
               $homepage->setAboutUsThirdPointImage($params['about_us_third_point_image']);
             }

             $em->persist($homepage);
             $em->flush();

             $response = new Response(json_encode(
             [
               'code' => 200,
               'message' => 'OK'
             ]));

         }else{

             $response = new Response(json_encode(
             [
               'code' => 1,
               'message' => 'Invalid Form'
             ]));
         }

         $response->headers->set('Content-Type', 'application/json');
         return $response;

    }
}
