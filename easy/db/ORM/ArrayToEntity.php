<?php

namespace easy\db\ORM;

class ArrayToEntity
{
    /**
     * @param string $entity
     * @param array $data
     * @return Entity
     */
    public function transform2(string $entity, array $data): Entity
    {
        ;
    }

    /**
     * @param string $entity
     * @param array $data
     * @return Entity
     * @throws \ReflectionException
     */
    public function transform(string $entity, array $data): Entity
    {
        $entity = new $entity;
        foreach ($data as $name => $value) {
            $property = new \ReflectionProperty($entity, $name);

            switch ($property->getType()->getName()) {
                case 'int':
                case 'float':
                case 'double':
                case 'string':
                case 'bool':
                    $entity->$name = $value;
                    continue 2;
            }

            if (\DateTimeImmutable::class === $property->getType()->getName()) {
                $entity->$name = $value ? new \DateTimeImmutable($value) : null;
            } elseif (\DateTime::class === $property->getType()->getName()) {
                $entity->$name = $value ? new \DateTime($value) : null;
            } elseif (enum_exists($property->getType()->getName())) {
                $typename = $property->getType()->getName();
                $entity->$name = $value ? $typename::from($value) : null;
            }


        }
        return $entity;
    }
}
