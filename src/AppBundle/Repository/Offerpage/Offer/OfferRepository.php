<?php

namespace AppBundle\Repository\Offerpage\Offer;

use AppBundle\Repository\Repository;

/**
 * SiteRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OfferRepository extends Repository{

	public function getPaginated($limit, $offset, $filters = []){

		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Offerpage\Offer\Offer', 'p');
		$data->where('p.active =true');
		$data->andWhere('((p.publish IS NOT NULL AND p.publish <= :date_now AND p.publish_until IS NULL)'.
				'OR (p.publish IS NOT NULL AND p.publish <= :date_now AND p.publish_until IS NOT NULL AND p.publish_until >= :date_now )'.
				'OR (p.publish IS NULL AND p.publish_until IS NOT NULL AND p.publish_until >= :date_now )'.
				'OR (p.publish IS NULL AND p.publish_until IS NULL )'.
				')');
		$data->setParameter('date_now' , (new \DateTime())->format('Y-m-d') );

		if(isset($filters['search']) && $filters['search'] != "" ){
			$data->andWhere('p.search LIKE  :search');
			$data->setParameter('search' , '%'.$filters['search'].'%');
		}
		if(isset($filters['show_homepage']) && $filters['show_homepage'] == true){
			$data->andWhere('p.show_homepage = true');
		}

		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();

		$data->select('p');
		$data->setFirstResult($offset);
		$data->setMaxResults($limit);
		$data->orderBy('p.publish_until', 'asc');
		$data->addOrderBy('p.id', 'asc');
		$result = $data->getQuery()->getResult();

		$final = [];
		foreach($result as $offer){
			$result_offer = [];
			$result_offer['id'] = $offer->getId();
        	$result_offer['title'] = $offer->getTitle();
        	$result_offer['slug'] = $offer->getSlug();
        	$result_offer['excerpt'] = $offer->getExcerpt();
        	$result_offer['body'] = $offer->getBody();
        	$result_offer['is_active'] = $offer->isActive();
        	$result_offer['show_homepage'] = $offer->getShowHomepage();
        	$result_offer['active'] = $offer->getActive();
        	$result_offer['is_published'] = $offer->isPublished();
        	$result_offer['publish'] = (is_null($offer->getPublish()))?null:$offer->getPublish()->getTimestamp();
        	$result_offer['publish_until'] = (is_null($offer->getPublishUntil()))?null:$offer->getPublishUntil()->getTimestamp();
        	$result_offer['meta_title'] = $offer->getMetaTitle();
        	$result_offer['meta_description'] = $offer->getMetaDescription();
        	$result_offer['btn_text'] = $offer->getBtnText();
        	$result_offer['btn_action'] = $offer->getBtnAction();
        	$result_offer['btn_contact_text'] = $offer->getBtnContactText();
        	$result_offer['btn_link'] = $offer->getBtnLink();
			if( ($item = $offer->getFeaturedItem()) !== FALSE)
				$result_offer['featured_image'] = array( 'url' => $item->getWebPath(), 'title' => $item->getTitle()  );
			$final[] = $result_offer;
		}

		return $this->payload($total, $limit, $offset, $final);

	}

	public function getAllPaginated($limit, $offset, $filters = []){

		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Offerpage\Offer\Offer', 'p');
		$data->where('1=1');

		if(isset($filters['search']) && $filters['search'] != "" ){
			$data->andWhere('p.search like :search');
			$data->setParameter('search' , "%".$filters['search']."%" );
		}
		if(isset($filters['search_by']) && $filters['search_by'] != "" ){
			switch ($filters['search_by']){
				case 'published':
						$data->andWhere('(p.active =true AND ((p.publish IS NOT NULL AND p.publish <= :date_now AND p.publish_until IS NULL)'.
						'OR (p.publish IS NOT NULL AND p.publish <= :date_now AND p.publish_until IS NOT NULL AND p.publish_until >= :date_now )'.
						'OR (p.publish IS NULL AND p.publish_until IS NOT NULL AND p.publish_until >= :date_now )'.
						'OR (p.publish IS NULL AND p.publish_until IS NULL )'.
						'))');
						$data->setParameter('date_now' , (new \DateTime())->format('Y-m-d') );
					break;
				case 'unpublished':
						$data->andWhere('NOT((p.active =true  AND (p.publish IS NOT NULL AND p.publish <= :date_now AND p.publish_until IS NULL)'.
						'OR (p.publish IS NOT NULL AND p.publish <= :date_now AND p.publish_until IS NOT NULL AND p.publish_until >= :date_now )'.
						'OR (p.publish IS NULL AND p.publish_until IS NOT NULL AND p.publish_until >= :date_now )'.
						'OR (p.publish IS NULL AND p.publish_until IS NULL )'.
						')) OR p.active = false');
						$data->setParameter('date_now' , (new \DateTime())->format('Y-m-d')  );
					break;
			}
		}

		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();

		$data->select('p');
		$data->setFirstResult($offset);
		$data->setMaxResults($limit);
		$data->orderBy('p.publish', 'desc');
		$result = $data->getQuery()->getResult();

		$final = [];
		foreach($result as $offer){
			$result_offer = [];
			$result_offer['id'] = $offer->getId();
        	$result_offer['title'] = $offer->getTitle();
        	$result_offer['slug'] = $offer->getSlug();
        	$result_offer['excerpt'] = $offer->getExcerpt();
        	$result_offer['body'] = $offer->getBody();
        	$result_offer['is_active'] = $offer->isActive();
        	$result_offer['show_homepage'] = $offer->getShowHomepage();
        	$result_offer['active'] = $offer->getActive();
        	$result_offer['is_published'] = $offer->isPublished();
        	$result_offer['publish'] = (is_null($offer->getPublish()))?null:$offer->getPublish()->getTimestamp();
        	$result_offer['publish_f'] = (is_null($offer->getPublish()))?null:$offer->getPublish()->format('d-m-Y');
        	$result_offer['publish_until'] = (is_null($offer->getPublishUntil()))?null:$offer->getPublishUntil()->getTimestamp();
					$result_offer['publish_untilf'] = (is_null($offer->getPublishUntil()))?null:$offer->getPublishUntil()->format('d-m-Y');
					$result_offer['meta_title'] = $offer->getMetaTitle();
        	$result_offer['meta_description'] = $offer->getMetaDescription();
        	$result_offer['btn_text'] = $offer->getBtnText();
        	$result_offer['btn_action'] = $offer->getBtnAction();
        	$result_offer['btn_contact_text'] = $offer->getBtnContactText();
        	$result_offer['btn_link'] = $offer->getBtnLink();
			if( ($item = $offer->getFeaturedItem()) !== FALSE)
				$result_offer['featured_image'] = array( 'url' => $item->getWebPath(), 'title' => $item->getTitle()  );
			$final[] = $result_offer;
		}

		return $this->payload($total, $limit, $offset, $final);

	}

	public function countOffers(){

		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Offerpage\Offer\Offer', 'p');
		$data->where('p.publish IS NOT NULL');
		$data->andWhere('p.publish >= :date_now');
		$data->setParameters(array('date_now' => (new \DateTime()) ));
		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();

		return $total;

	}


	public function checkSlug( $slug, $id = null ){

		$data = $this->getEntityManager()->createQueryBuilder();
		$data->from('AppBundle\Entity\Offerpage\Offer\Offer', 'p');
		$data->where('p.slug = :slug');
		$data->setParameter('slug',$slug);
		if(!is_null($id)){
			$data->andWhere('p.id != :id');
			$data->setParameter('id', $id);
		}
		$count = clone $data;
		$count->select('count(p.id)');
		$total = $count->getQuery()->getSingleScalarResult();

		return $total;

	}


}
