<?php

namespace CoreBundle\Doctrine;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;

abstract class AbstractManager
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var ObjectRepository
     */
    protected $repository;


    public function __construct(ObjectManager $om, string $class)
    {
        $this->objectManager = $om;
        $this->repository = $om->getRepository($class);

        $metadata = $om->getClassMetadata($class);
        $this->class = $metadata->getName();
    }

    public function create(): object
    {
        $class = $this->class;
        $object = new $class;

        return $object;
    }

    public function delete(object $object): void
    {
        $this->objectManager->remove($object);
        $this->objectManager->flush();
    }

    public function find(int $id): ?object
    {
        return $this->repository->find($id);
    }

    public function findOneBy(array $criteria): ?object
    {
        return $this->repository->findOneBy($criteria);
    }

    public function findBy(array $criteria): array
    {
        return $this->repository->findBy($criteria);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function refresh(object $object): void
    {
        $this->objectManager->refresh($object);
    }

    public function update(object $object): void
    {
        $this->objectManager->persist($object);
        $this->objectManager->flush();
    }

    public function getRepository(): ObjectRepository
    {
        return $this->repository;
    }
}
