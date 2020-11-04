<?php

declare(strict_types=1);

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\SluggableInterface;
use Knp\DoctrineBehaviors\Model\Sluggable\SluggableTrait;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table(name="site_user")
 * @ORM\Entity(repositoryClass="App\Repository\Admin\UserRepository")
 * @UniqueEntity(fields={"email"})
 * @UniqueEntity(fields={"username"})
 */
class User implements UserInterface, \Serializable, SluggableInterface
{
    use SluggableTrait;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(name="username", type="string", unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="surname", type="string", length=100, nullable=true)
     */
    private $surname;

    /**
     * @ORM\Column(name="email", type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(name="about", type="text", nullable=true)
     */
    private $about;

    /**
     * @ORM\Column(name="email_confirmed", type="boolean", options={"default" : false})
     */
    private $emailConfirmed = false;

    /**
     * @ORM\Column(name="enabled", type="boolean", options={"default" : false})
     */
    private $enabled = false;

    /**
     * @ORM\Column(name="password", type="string")
     */
    private $password;

    /**
     * @ORM\Column(name="roles", type="json")
     */
    protected $roles;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = strtolower($email);

        return $this;
    }

    public function getAbout(): ?string
    {
        return $this->about;
    }

    public function setAbout(?string $about): self
    {
        $this->about = $about;

        return $this;
    }

    public function isEmailConfirmed(): bool
    {
        return $this->emailConfirmed;
    }

    public function setEmailConfirmed(bool $emailConfirmed): self
    {
        $this->emailConfirmed = strtolower($emailConfirmed);

        return $this;
    }

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    function __toString()
    {
        if (!$this->name && !$this->surname && !$this->username) {
            return '';
        }

        if ($this->name || $this->surname) {
            return sprintf('%s %s (%s)',
                $this->name,
                $this->surname,
                $this->username
            );
        }

        return $this->username;
    }

    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->name,
            $this->surname,
            $this->password,
            $this->enabled,
        ));
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->name,
            $this->surname,
            $this->password,
            $this->enabled
            ) = unserialize($serialized);
    }

    public function getSalt()
    {
        return null;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function eraseCredentials()
    {

    }

    public function getSluggableFields(): array
    {
        return ['username'];
    }

    protected function getRegenerateSlugOnUpdate(): bool
    {
        return false;
    }
}
