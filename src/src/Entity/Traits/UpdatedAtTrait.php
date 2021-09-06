<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 **/
trait UpdatedAtTrait
{
    /**
     * @ORM\Column(name="updated_at", type="datetime",nullable=true)
     **/

    protected DateTime $updatedAt;

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function updateUpdatedAt(): void
    {
        $this->updatedAt = new DateTime();
    }
}
