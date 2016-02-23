<?php

namespace AppBundle\Repository\Gallery\Item;

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
      $data->select('i')->from('AppBundle\Entity\Gallery\Item\Item', 'i');
      $data->setFirstResult($offset);
      $data->setMaxResults($limit);
      $data->orderBy('i.id', 'DESC');
      $result = $data->getQuery()->getResult();

      $count = $this->getEntityManager()->createQueryBuilder();
      $count->select('count(i.id)')->from('AppBundle\Entity\Gallery\Item\Item', 'i');
      $total = $count->getQuery()->getSingleScalarResult();

      return $this->payload($total, $limit, $offset, $result);
  }

  public function getPaginated($limit, $offset, $path){

      $data = $this->getEntityManager()->createQueryBuilder();
      $data->select('i')->from('AppBundle\Entity\Gallery\Item\Item', 'i');
      $data->setFirstResult($offset);
      $data->setMaxResults($limit);
      $data->orderBy('i.id', 'desc');
      $result = $data->getQuery()->getResult();

      $count = $this->getEntityManager()->createQueryBuilder();
      $count->select('count(i.id)')->from('AppBundle\Entity\Gallery\Item\Item', 'i');
      $total = $count->getQuery()->getSingleScalarResult();

      $final = [];
      foreach($result as $i){
        $final[] = [
          'id' => $i->getId(),
          'title' => $i->getTitle(),
          'image_url' => (is_null($i->getPath())) ? null : $path.$i->getPath()
        ];
      }

      return $this->payload($total, $limit, $offset, $final);

  }
}
