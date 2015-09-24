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

  public function getForDisplay(){

      $data = $this->getEntityManager()->createQueryBuilder();
      $data->select('i')->from('AppBundle\Entity\Review\Item\Item', 'i');
      $data->orderBy('i.id', 'DESC');
      return $data->getQuery()->getResult();
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
          'job_location' => (is_object($item->getJobLocation()) && !is_null($item->getJobLocation())) ? $item->getJobLocation()->format('Y-m-d') : '',
          'rate_time_management' => $item->getRateTimeManagement(),
          'rate_friendly' => $item->getRateFriendly(),
          'rate_tidiness' => $item->getRateTidiness(),
          'rate_value' => $item->getRateValue(),
          'rate_total' => $item->getRateTotal()
        ];
      }

      return $this->payload($total, $limit, $offset, $final);

  }

}
