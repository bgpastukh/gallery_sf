<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GalleryRepository")
 * @ORM\Table(name="gallery")
 * @ORM\HasLifecycleCallbacks()
 */
class Gallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=128, nullable=false)
     */

    protected $name;
    /**
     * @ORM\Column(type="datetime")
     */
    protected $date;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(message="Enter comment")
     *
     * @Assert\Length(min=5, max=100, minMessage="To short comment!", maxMessage="To long comment")
     */
    protected $comment;

    /**
     * @ORM\Column(type="integer")
     */
    protected $size;

    /**
     * Get id
     *
     * @return integer
     */

    /**
     * @Assert\File(maxSize="1000000", maxSizeMessage="To big image", mimeTypes={"image/png", "image/jpg", "image/jpeg"}, mimeTypesMessage="Not allowed format")
     *
     * @Assert\NotBlank(message="Choose your image")
     */
    private $file;

    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Gallery
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set date
     *
     * @ORM\PrePersist()
     *
     * @ORM\PreUpdate()
     *
     * @return Gallery
     */
    public function setDate()
    {
        $this->date = new \DateTime();

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Gallery
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return Gallery
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return integer
     */
    public function getSize()
    {
        return $this->size;
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

    public function getPath()
    {
        return "uploads/" . $this->getName();
    }

    public function getAbsolutePath()
    {
        return "/uploads/" . $this->getName();
    }
}
