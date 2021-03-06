<?php

namespace AppBundle\Repository\Review\Item;

use AppBundle\Repository\Repository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ItemRepository extends Repository{

  public function getForDisplay($limit, $offset){

      $data = $this->getEntityManager()->createQueryBuilder();
      $data->select('i')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $data->setFirstResult($offset);
      $data->setMaxResults($limit);
      $data->orderBy('i.job_done_date', 'DESC');
      $result = $data->getQuery()->getResult();

      $count = $this->getEntityManager()->createQueryBuilder();
      $count->select('count(i.id)')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $total = $count->getQuery()->getSingleScalarResult();

      return $this->payload($total, $limit, $offset, $result);
  }

  public function getPaginated($limit, $offset, $slidersPath){

      $data = $this->getEntityManager()->createQueryBuilder();
      $data->select('i')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $data->setFirstResult($offset);
      $data->setMaxResults($limit);
      $data->orderBy('i.id', 'desc');

      $count = $this->getEntityManager()->createQueryBuilder();
      $count->select('count(i.id)')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $total = $count->getQuery()->getSingleScalarResult();

      $final = [];
      foreach($data->getQuery()->getResult() as $item){
        $final[] = [
          'id' => $item->getId(),
          'expert_trades_review_id' => $item->getExpertTradesReviewId(),
          'title' => $item->getTitle(),
          'message' => $item->getMessage(),
          'job_description' => $item->getJobDescription(),
          'job_location' => $item->getJobLocation(),
          'job_done_date' => (is_object($item->getJobDoneDate()) && !is_null($item->getJobDoneDate())) ? $item->getJobDoneDate()->format('Y-m-d') : '',
          'rate_time_management' => $item->getRateTimeManagement(),
          'rate_friendly' => $item->getRateFriendly(),
          'rate_tidiness' => $item->getRateTidiness(),
          'rate_value' => $item->getRateValue(),
          'rate_total' => $item->getRateTotal()
        ];
      }

      return $this->payload($total, $limit, $offset, $final);

  }


  public function getReview( $id ){
  
  	$data = $this->getEntityManager()->createQueryBuilder();
  	$data->select('i')->from('AppBundle\Entity\Review\Item\Item', 'i');
  	$data->Where('i.id = :id');
  	$data->setParameter('id', $id);
  	$result = $data->getQuery()->getResult();
  	return (is_array($result))?$result[0]:null;
  }
  
  
  public function getBestReview(){

      $data = $this->getEntityManager()->createQueryBuilder();
      $data->select('i')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $data->setFirstResult(0);
      $data->setMaxResults(1);
      $data->orderBy('i.rate_total', 'Desc');
      $data->addOrderBy('i.job_done_date', 'Desc');
      $result = $data->getQuery()->getResult();
      
      return (is_array($result))?$result[0]:null;
  }
  
  public function getWorstReview(){

      $data = $this->getEntityManager()->createQueryBuilder();
      $data->select('i')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $data->setFirstResult(0);
      $data->setMaxResults(1);
      $data->orderBy('i.rate_total', 'ASC');
      $result = $data->getQuery()->getSingleScalarResult();
      return $result;
      
  }
  
  
  public function getInfoReview(){

      $data = $this->getEntityManager()->createQueryBuilder();
      $data->select('count(i.rate_total) as num_reviews , SUM( i.rate_total ) as rate_total  ')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $data->orderBy('i.rate_total', 'DESC');
      $result = $data->getQuery()->getResult();
      return (is_array($result))?$result[0]:null;
      
  }

}
