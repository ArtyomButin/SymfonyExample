<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM,
    App\DBAL\Types\GenderType,
    Fresh\DoctrineEnumBundle\Validator\Constraints as DoctrineAssert,
    App\Repository\UsersRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface
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
    private ?string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $second_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $last_name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private ?string $phone;

    /**
     * @ORM\Column(type="integer")
     */
    private ?int $age;

    /**
     * @ORM\Column(name="gender", type="gender", nullable=false)
     * @DoctrineAssert\Enum(entity="App\DBAL\Types\GenderType")
     */
    private mixed $gender;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $password;

    /**
     * @ORM\Column(type="integer")
     */
    private int $role;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSecondName(): ?string
    {
        return $this->second_name;
    }

    public function setSecondName(?string $second_name): self
    {
        $this->second_name = $second_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(?string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @return mixed
     */
    public function getGender(): mixed
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function addNewUser(array $params): self
    {
    }

    public function getRoles(): array|int
    {
        return $this->role;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getSalt(): ?string
    {
        return md5(uniqid('', true));
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }
}
