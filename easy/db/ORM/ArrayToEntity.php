<?php

namespace easy\db\ORM;

use app\entities\GuestbookEntry;
use easy\Application;

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
            switch ($propertyType->getName()) {
                case 'int':
                case 'integer':
                case 'float':
                case 'double':
                case 'string':
                case 'bool':
//                    if ('name' == $propertyName) {
//                        echo '<pre>';
//                        var_dump($data);
//                        echo '</pre>';die;
//                    }
//                    echo get_class($entity);
                    $entity->$propertyName = $data[$propertyName];
                    continue 2;
            }
            if ((!isset($data[$propertyName]) || null === $data[$propertyName])) {
                if ($propertyType->allowsNull()) {
                    $entity->$propertyName = null;
                } elseif (!class_exists($propertyType)) {
                    throw new \Exception("Поле $propertyName пустое, и не позволяет вставить значение NULL");
                } else {
                    $className = $propertyType->getName();
                    $storageName = str_replace('entities', 'storages', $className);
                    $column = strtolower(str_replace('app\storages\\', '', $storageName)) . '_id';
                    $storageName .= 'Storage';
                    //$entity->$column;
                    $storage = (Application::$serviceContainer->init($storageName));
                    $entity->$propertyName = $storage->load($entity->$column)->asEntity() ;//?: $storage->load(23)->asEntity();
                }
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
