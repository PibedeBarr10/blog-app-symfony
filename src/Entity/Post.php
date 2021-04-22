<?php

namespace App\Entity;

use App\Repository\PostRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $body;

    /**
     * @ORM\Column(type="date")
     */
    private $creation_date;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="post")
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=FavouritePost::class, mappedBy="post")   # orphanRemoval=true - usuwa wszystkie powiązane ulubione posty
     */
    private $favouritePosts;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post")
     */
    private $comments;

    /**
     * @ORM\Column(type="boolean")
     */
    private $visible;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->favouritePosts = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreationDate(): ?DateTimeInterface
    {
        return $this->creation_date;
    }

    public function setCreationDate(DateTimeInterface $creation_date): self
    {
        $this->creation_date = $creation_date;

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setPost($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getPost() === $this) {
                $like->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FavouritePost[]
     */
    public function getFavouritePosts(): Collection
    {
        return $this->favouritePosts;
    }

    public function addFavouritePost(FavouritePost $favouritePost): self
    {
        if (!$this->favouritePosts->contains($favouritePost)) {
            $this->favouritePosts[] = $favouritePost;
            $favouritePost->setPost($this);
        }

        return $this;
    }

    public function removeFavouritePost(FavouritePost $favouritePost): self
    {
        if ($this->favouritePosts->removeElement($favouritePost)) {
            // set the owning side to null (unless already changed)
            if ($favouritePost->getPost() === $this) {
                $favouritePost->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function getVisible(): ?bool
    {
        return $this->visible;
    }

    public function setVisible(bool $visible): self
    {
        $this->visible = $visible;

        return $this;
    }
}
