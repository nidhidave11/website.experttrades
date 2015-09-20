<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use AppBundle\Entity\Review\Item\Item;

class ReviewController extends SecurityController
{
    /**
     * @Route("/api/v1/review", name="get_review")
     * @Method({"GET"})
     */
    public function getAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);

        $response = new Response(json_encode(
        [
          'header_text' => $review->getHeaderText(),
          'header_title' => $review->getHeaderTitle(),
        ]));
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/api/v1/review", name="post_review")
     * @Method({"POST"})
     */
    public function postAction(Request $request)
    {
         $this->checkAccess($request);

         $em = $this->getDoctrine()->getManager();
         $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);

         $params = array();
         $content = $this->get("request")->getContent();
         if (!empty($content))
         {
             $params = json_decode($content, true); // 2nd param to get as array

             if(isset($params['header_text'])){
               $review->setHeaderText($params['header_text']);
             }
             if(isset($params['header_title'])){
               $review->setHeaderTitle($params['header_title']);
             }

             $em->persist($review);
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

    /**
     * @Route("/api/v1/review_items", name="get_review_items", requirements={"offset" = "\d+", "limit" = "\d+"}, defaults={"offset" = 0, "limit" = 10})
     * @Method({"GET"})
     */
    public function getItemsAction(Request $request)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();

      $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/images/reviews/';
      if(!in_array($this->container->get( 'kernel' )->getEnvironment(), array('prod'))){
            $slidersPath = 'http://'.$request->server->get('HTTP_HOST').'/website.experttrades/web/images/reviews/';
      }

      $limit = $request->query->get('limit');
      $limit = (is_null($limit)) ? 10 : $limit;

      $offset = $request->query->get('offset');
      $offset = (is_null($offset)) ? 0 : $offset;

      $images =  $em->getRepository('AppBundle\Entity\Review\Item\Item')
      ->getPaginated($limit, $offset, $slidersPath);

      $response = new Response(json_encode($images));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/review_items/{id}", name="get_review_item")
     * @Method({"GET"})
     */
    public function getItemAction(Request $request, $id)
    {
      $this->checkAccess($request);

      $em = $this->getDoctrine()->getManager();
      $item =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->find($id);

      $response = new Response(json_encode([
        'id' => $item->getId(),
        'title' => $item->getTitle(),
        'message' => $item->getMessage(),
        'job_description' => $item->getJobDescription(),
        'job_location' => (is_object($item->getJobLocation()) && !is_null($item->getJobLocation())) ? $item->getJobLocation()->format('Y-m-d') : '',
        'rate_time_management' => $item->getRateTimeManagement(),
        'rate_friendly' => $item->getRateFriendly(),
        'rate_tidiness' => $item->getRateTidiness(),
        'rate_value' => $item->getRateValue(),
        'rate_total' => $item->getRateTotal()

      ]));
      $response->headers->set('Content-Type', 'application/json');

      return $response;

    }

    /**
     * @Route("/api/v1/review_items", name="post_review_items")
     * @Method({"POST"})
     */
    public function postItemAction(Request $request)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $review =  $em->getRepository('AppBundle\Entity\Review\Review')->find(1);

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $item = new Item();
          $item->setFile($file);
          $item->upload();
          $em->persist($item);
          $em->flush();

          $response = new Response(json_encode(
          [
            'code' => 200,
            'message' => 'OK'
          ]));

          $response->headers->set('Content-Type', 'application/json');
          return $response;

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

    /**
     * @Route("/api/v1/review_items/{id}", name="put_review_items")
     * @Method({"PUT"})
     */
    public function putItemAction(Request $request, $id)
    {
        $this->checkAccess($request);

        $em = $this->getDoctrine()->getManager();
        $item =  $em->getRepository('AppBundle\Entity\Review\Item\Item')->find($id);

        $file = $request->files->get('file');
        if(!is_null($file)) {

          $item->setFile($file);
          $item->upload();
          $em->persist($item);
          $em->flush();

          $response = new Response(json_encode(
          [
            'code' => 200,
            'message' => 'OK'
          ]));

          $response->headers->set('Content-Type', 'application/json');
          return $response;

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
