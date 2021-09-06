<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 */
trait CreatedAtTrait
{
    /**
     * @var DateTime
     * @ORM\Column(type="datetime", name="created_at", nullable=false)
     */
    protected $createdAt;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAt():void
    {
        $this->createdAt = new DateTime();
    }
}
