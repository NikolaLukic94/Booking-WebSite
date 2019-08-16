<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $address_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=190, nullable=true)
     */
    private $duration;

    /**
     * @ORM\Column(type="date")
     */
    private $starting_from_date;

    /**
     * @ORM\Column(type="date")
     */
    private $until_date;

    /**
     * @ORM\Column(type="integer")
     */
    private $guests_number;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $note;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddressId(): ?int
    {
        return $this->event_id;
    }

    public function setAddressId(int $event_id): self
    {
        $this->event_id = $event_id;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(?string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getStartingFromDate(): ?\DateTimeInterface
    {
        return $this->starting_from_date;
    }

    public function setStartingFromDate(\DateTimeInterface $starting_from_date): self
    {
        $this->starting_from_date = $starting_from_date;

        return $this;
    }

    public function getUntilDate(): ?\DateTimeInterface
    {
        return $this->until_date;
    }

    public function setUntilDate(\DateTimeInterface $until_date): self
    {
        $this->until_date = $until_date;

        return $this;
    }

    public function getGuestsNumber(): ?int
    {
        return $this->guests_number;
    }

    public function setGuestsNumber(int $guests_number): self
    {
        $this->guests_number = $guests_number;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }
}
