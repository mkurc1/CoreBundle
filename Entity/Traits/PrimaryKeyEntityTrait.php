<?php

namespace CoreBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait PrimaryKeyEntityTrait
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}
