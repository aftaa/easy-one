<?php

namespace easy\db\ORM;

use app\entities\Author;
use app\entities\GuestbookEntry;
use easy\Application;
use easy\basic\DependencyInjection;

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
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyType = $property->getType();
            switch ($propertyType->getName()) {
                case 'int':
                case 'integer':
                case 'float':
                case 'double':
                case 'string':
                case 'bool':
                    if (!$data[$propertyName] && $propertyType->allowsNull()) {
                        $entity->$propertyName = null;
                    } else {
                        $entity->$propertyName = $data[$propertyName];
                    }
                    continue 2;
                case \DateTime::class:
                    if (!$data[$propertyName] && $propertyType->allowsNull()) {
                        $entity->$propertyName = null;
                    } else {
                        $entity->$propertyName = new \DateTime($data[$propertyName] ?? 'now');
                    }
                    continue 2;
                case \DateTimeImmutable::class:
                    if (!$data[$propertyName] && $propertyType->allowsNull()) {
                        $entity->$propertyName = null;
                    } else {
                        $entity->$propertyName = new \DateTimeImmutable($data[$propertyName] ?? 'now');
                    }
                    continue 2;
            }

/*            if ((!isset($data[$propertyName]) || null === $data[$propertyName])) {
                if ($propertyType->allowsNull()) {
                    $entity->$propertyName = null;
                } elseif (!class_exists($propertyType)) {
                    throw new \Exception("Поле $propertyName пустое, и не позволяет вставить значение NULL");
                } else {

                }
            }*/

            if (enum_exists($propertyType->getName())) {
                $typename = $propertyType->getName();
                $value = isset($data[$propertyName]) ? $data[$propertyName] : null;
                $entity->$propertyName = $value ? $typename::from($value) : null;
            } elseif (class_exists($propertyType->getName())) {
                $this->getColumnValue($entity, $data, $propertyType, $propertyName);
            }
        }
        return $entity;
    }

    /**
     * @param Entity $entity
     * @param array $data
     * @param \ReflectionNamedType $propertyType
     * @param string $propertyName
     * @return void
     */
    private function getColumnValue(Entity $entity, array $data, \ReflectionNamedType $propertyType, string $propertyName): void
    {
        $className = $propertyType->getName();
        $storageName = str_replace('entities', 'storages', $className);
        $columnName = strtolower(str_replace('app\storages\\', '', $storageName)) . '_id';
        $storageName .= 'Storage';
        $storage = Application::$serviceContainer->init($storageName);
        $entity->$propertyName = $storage->load($entity->$columnName)->asEntity();
    }
}
