<?php

namespace AppBundle\Entity\Homepage;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * AppBundle\Entity\Homepage\Homepage
 * @ORM\Table(name="homepage")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Homepage\HomepageRepository")
 */
class Homepage{

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Homepage\Slider\Slider", mappedBy="homepage")
     */
     private $sliders;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     */
    private $id;

    /**
     * @var string $reviews_title
     *
     * @ORM\Column(name="reviews_title", type="text", length=2555, nullable=true)
     */
    private $reviews_title;

    /**
     * @var string $reviews_subtitle
     *
     * @ORM\Column(name="reviews_subtitle", type="text", length=2555, nullable=true)
     */
    private $reviews_subtitle;

    /**
     * @var string $services_title
     *
     * @ORM\Column(name="services_title", type="text", length=2555, nullable=true)
     */
    private $services_title;

    /**
     * @var string $services_subtitle
     *
     * @ORM\Column(name="services_subtitle", type="text", length=2555, nullable=true)
     */
    private $services_subtitle;

    /**
     * @var string $gallery_title
     *
     * @ORM\Column(name="gallery_title", type="text", length=2555, nullable=true)
     */
    private $gallery_title;

    /**
     * @var string $gallery_subtitle
     *
     * @ORM\Column(name="gallery_subtitle", type="text", length=2555, nullable=true)
     */
    private $gallery_subtitle;

    /**
     * @var string $contact_us_title
     *
     * @ORM\Column(name="contact_us_title", type="text", length=2555, nullable=true)
     */
    private $contact_us_title;

    /**
     * @var string $contact_us_subtitle
     *
     * @ORM\Column(name="contact_us_subtitle", type="text", length=2555, nullable=true)
     */
    private $contact_us_subtitle;

    /**
     * @var string $find_me_on_title
     *
     * @ORM\Column(name="find_me_on_title", type="text", length=2555, nullable=true)
     */
    private $find_me_on_title;

    /**
     * @var string $find_me_on_subtitle
     *
     * @ORM\Column(name="find_me_on_subtitle", type="text", length=2555, nullable=true)
     */
    private $find_me_on_subtitle;

    /**
     * @var string $meta_title
     *
     * @ORM\Column(name="meta_title", type="text", length=2555, nullable=true)
     */
    private $meta_title;

    /**
     * @var string $meta_description
     *
     * @ORM\Column(name="meta_description", type="text", length=2555, nullable=true)
     */
    private $meta_description;

    /**
     * @var integer $slider_type
     * 0 -> normal 1 btn
     * 1 -> type config buttons
     *
     * @ORM\Column(name="slider_type", type="integer",  options={"default" = "0"})
     */
    private $slider_type;

    public function __construct(){

        $this->sliders = new ArrayCollection();
        $this->slider_type = 0;
    }

    /**
     * Get sliders
     *
     * @return ArrayCollection
     */
    public function getSliders()
    {
        return $this->sliders;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set reviews_title
     *
     * @param string $reviews_title
     */
    public function setReviewsTitle($reviews_title)
    {
        $this->reviews_title = $reviews_title;
    }

    /**
     * Get reviews_title
     *
     * @return string
     */
    public function getReviewsTitle()
    {
        return $this->reviews_title;
    }

    /**
     * Set reviews_subtitle
     *
     * @param string $reviews_subtitle
     */
    public function setReviewsSubtitle($reviews_subtitle)
    {
        $this->reviews_subtitle = $reviews_subtitle;
    }

    /**
     * Get reviews_subtitle
     *
     * @return string
     */
    public function getReviewsSubtitle()
    {
        return $this->reviews_subtitle;
    }

    /**
     * Set services_title
     *
     * @param string $services_title
     */
    public function setServicesTitle($services_title)
    {
        $this->services_title = $services_title;
    }

    /**
     * Get services_title
     *
     * @return string
     */
    public function getServicesTitle()
    {
        return $this->services_title;
    }

    /**
     * Set services_subtitle
     *
     * @param string $services_subtitle
     */
    public function setServicesSubtitle($services_subtitle)
    {
        $this->services_subtitle = $services_subtitle;
    }

    /**
     * Get services_subtitle
     *
     * @return string
     */
    public function getServicesSubtitle()
    {
        return $this->services_subtitle;
    }

    /**
     * Set gallery_title
     *
     * @param string $gallery_title
     */
    public function setGalleryTitle($gallery_title)
    {
        $this->gallery_title = $gallery_title;
    }

    /**
     * Get gallery_title
     *
     * @return string
     */
    public function getGalleryTitle()
    {
        return $this->gallery_title;
    }

    /**
     * Set gallery_subtitle
     *
     * @param string $gallery_subtitle
     */
    public function setGallerySubtitle($gallery_subtitle)
    {
        $this->gallery_subtitle = $gallery_subtitle;
    }

    /**
     * Get gallery_subtitle
     *
     * @return string
     */
    public function getGallerySubtitle()
    {
        return $this->gallery_subtitle;
    }

    /**
     * Set contact_us_title
     *
     * @param string $contact_us_title
     */
    public function setContactUsTitle($contact_us_title)
    {
        $this->contact_us_title = $contact_us_title;
    }

    /**
     * Get contact_us_title
     *
     * @return string
     */
    public function getContactUsTitle()
    {
        return $this->contact_us_title;
    }

    /**
     * Set contact_us_subtitle
     *
     * @param string $contact_us_subtitle
     */
    public function setContactUsSubtitle($contact_us_subtitle)
    {
        $this->contact_us_subtitle = $contact_us_subtitle;
    }

    /**
     * Get contact_us_subtitle
     *
     * @return string
     */
    public function getContactUsSubtitle()
    {
        return $this->contact_us_subtitle;
    }

    /**
     * Set find_me_on_title
     *
     * @param string $find_me_on_title
     */
    public function setFindMeOnTitle($find_me_on_title)
    {
        $this->find_me_on_title = $find_me_on_title;
    }

    /**
     * Get find_me_on_title
     *
     * @return string
     */
    public function getFindMeOnTitle()
    {
        return $this->find_me_on_title;
    }

    /**
     * Set find_me_on_subtitle
     *
     * @param string $find_me_on_subtitle
     */
    public function setFindMeOnSubtitle($find_me_on_subtitle)
    {
        $this->find_me_on_subtitle = $find_me_on_subtitle;
    }

    /**
     * Get find_me_on_subtitle
     *
     * @return string
     */
    public function getFindMeOnSubtitle()
    {
        return $this->find_me_on_subtitle;
    }

    /**
     * Get header_text
     *
     * @return string
     */
    public function getHeaderText()
    {
        return $this->header_text;
    }

    /**
     * Set meta_title
     *
     * @param string $meta_title
     */
    public function setMetaTitle($meta_title)
    {
        $this->meta_title = $meta_title;
    }

    /**
     * Get meta_title
     *
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->meta_title;
    }

    /**
     * Set meta_description
     *
     * @param string $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    /**
     * Get meta_description
     *
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }
	public function getSliderType() {
		return $this->slider_type;
	}
	public function setSliderType($slider_type) {
		$this->slider_type = $slider_type;
		return $this;
	}

}
