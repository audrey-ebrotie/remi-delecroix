<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[Vich\Uploadable]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 45)]
    #[Assert\NotBlank(message: "Veuillez entrer votre prénom ou un pseudo.")]
    #[Assert\Length(
        min: 2,
        max: 45,
        minMessage: "Votre prénom ou pseudo doit comporter au moins {{ limit }} caractères.",
        maxMessage: "Votre prénom ou pseudo doit comporter au maximum {{ limit }} caractères."
    )]
    private ?string $firstname = null;

    #[ORM\Column(length: 45, nullable: true)]
    private ?string $lastname = null;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: "Veuillez entrer un message.")]
    #[Assert\Length(
        min: 10,
        minMessage: "Le message doit comporter au moins {{ limit }} caractères."
    )]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    #[Assert\Image(
        maxSize: "2M",
        mimeTypes: [
            "image/jpg",
            "image/jpeg",
            "image/png",
        ],
        mimeTypesMessage: "Veuillez sélectionner un fichier au format jpg, jpeg ou png.",
        maxSizeMessage: "le fichier est trop volumineux. Sa taille ne doit pas dépasser 2 Mo."
    )]
    private ?string $image = null;

    #[Vich\UploadableField(mapping: 'comment_images_mapping', fileNameProperty: 'image')]
    #[Assert\File(mimeTypes: ['image/*'])]
    private ?File $imageFile = null;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updated_at = new \DateTimeImmutable();
        }
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }
}
