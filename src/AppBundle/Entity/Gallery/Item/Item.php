<?php

namespace AppBundle\Entity\Gallery\Item;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * AppBundle\Entity\Gallery\Item\Item
 * @ORM\Table(name="gallery_item")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="AppBundle\Repository\Gallery\Item\ItemRepository")
 */
class Item{

    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;

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
     * @var string $title
     *
     * @ORM\Column(name="title", type="text", length=2555, nullable=true)
     */
    private $title;

    /**
    * @ORM\Column(type="string", length=255, nullable=true)
    */
    public $path;

    public function __construct(){

    }

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
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
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues
        $filename = substr( md5(rand()), 0, 15).'.'.$this->getFile()->guessExtension();
        // move takes the target directory and then the
        // target filename to move to
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $filename
        );

        // set the path property to the filename where you've saved the file
        $this->path = $filename;

        // clean up the file property as you won't need it anymore
        $this->file = null;
     }

     public function getAbsolutePath()
     {
         return null === $this->path
             ? null
             : $this->getUploadRootDir().'/'.$this->path;
     }

     public function getWebPath()
     {
         return null === $this->path
             ? null
             : $this->getUploadDir().'/'.$this->path;
     }

     protected function getUploadRootDir()
     {
         // the absolute directory path where uploaded
         // documents should be saved
         return __DIR__.'/../../../../../web/'.$this->getUploadDir();
     }

     protected function getUploadDir()
     {
         // get rid of the __DIR__ so it doesn't screw up
         // when displaying uploaded doc/image in the view.
         return 'images/gallery';
     }
}