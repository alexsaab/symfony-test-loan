<?php

namespace App\Entity\Behavior;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

trait ImageTrait
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $image;

    #[UploadableField(mapping: 'uploads', fileNameProperty: 'image')]
    protected $imageFile;

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile(?File $imageFile)
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile) {
            $this->setUpdatedAt();
        }
    }
}
