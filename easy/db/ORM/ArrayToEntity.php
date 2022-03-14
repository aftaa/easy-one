<?php

namespace easy\db\ORM;

use app\entities\GuestbookEntry;

class ArrayToEntity
{
    /**
     * @param string $entityName
     * @param array $data
     * @return Entity
     * @throws \Exception
     */
    public function transform(string $entityName, array $data): Entity
    {
        $entity = new $entityName();
        $reflectionClass = new \ReflectionObject($entity);
        $properties = $reflectionClass->getProperties();
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyType = $property->getType();

            if ((!isset($data[$propertyName]) || null === $data[$propertyName]) && $propertyType->allowsNull()) {
                $entity->$propertyName = null;
            }
            switch ($propertyType->getName()) {
                case 'int':
                case 'integer':
                case 'float':
                case 'double':
                case 'string':
                case 'bool':
                    $entity->$propertyName = $data[$propertyName];
                    continue 2;
            }
            if (\DateTime::class == $propertyType) {
                $entity->$propertyName = new \DateTime($data[$propertyName] ?? 'now');
            } elseif (\DateTimeImmutable::class == $propertyType) {
                $entity->$propertyName = new \DateTimeImmutable($data[$propertyName] ?? 'now');
            } elseif (enum_exists($property->getType()->getName())) {
                $typename = $property->getType()->getName();
                $value = isset($data[$propertyName]) ? $data[$propertyName] : null;
                $entity->$propertyName = $value ? $typename::from($value) : null;
            }
        }
        return $entity;
    }
}
