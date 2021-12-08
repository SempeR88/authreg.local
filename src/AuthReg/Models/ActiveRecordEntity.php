<?php

namespace AuthReg\Models;

use AuthReg\Services\Db;

abstract class ActiveRecordEntity
{
	protected $id;

	public function getId(): int
	{
		return $this->id;
	}

	public function __set($name, $value)
	{
		$camelCaseName = $this->underscoreToCamelCase($name);
		$this->$camelCaseName = $value;
	}

	private function underscoreToCamelCase(string $source): string
	{
		return lcfirst(str_replace('_', '', ucwords($source, '_')));
	}

	public static function findAll(): array
	{
		$db = Db::getInstance();
		return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
	}

	abstract protected static function getTableName(): string;

	public static function getById(int $id): ?self
	{
		$db = Db::getInstance();
		$entities = $db->query(
			'SELECT * FROM `' . static::getTableName() . '` WHERE `id` = :id;', 
			[':id' => $id], 
			static::class
		);

		return $entities ? $entities[0] : null;
	}

	public function save(): void
	{
		$mappedProperties = $this->mapPropertiesToDbFormat();
	    if ($this->id !== null) {
	        $this->update($mappedProperties);
	    } else {
	        $this->insert($mappedProperties);
	    }
	}

	private function update(array $mappedProperties): void
	{
		$paramsNames = [];
	    $params = [];
	    foreach ($mappedProperties as $columnName => $value) {
	        $paramName = ':' . $columnName;
	        $paramsNames[] = '`' . $columnName . '` = ' . $paramName;
	        $params[$paramName] = $value;
	    }

		$sql = 'UPDATE `' . static::getTableName() . '` SET ' . implode(', ', $paramsNames) . ' WHERE `id` = ' . $this->id . ';';
	    $db = Db::getInstance();
		$db->query($sql, $params, static::class);
	}

	private function insert(array $mappedProperties): void
	{
		$filteredProperties = array_filter($mappedProperties);
		$columns = [];
		$paramsNames = [];
	    $params = [];
	    foreach ($filteredProperties as $columnName => $value) {
	    	$columns[] = '`' . $columnName . '`';
	        $paramName = ':' . $columnName;
	        $paramsNames[] = $paramName;
	        $params[$paramName] = $value;
	    }
	    
		$sql = 'INSERT INTO `' . static::getTableName() . '` (' . implode(', ', $columns) . ') VALUES (' . implode(', ', $paramsNames) . ');';
	    $db = Db::getInstance();
		$db->query($sql, $params, static::class);
		$this->id = $db->getLastInsertId();
		$this->refresh();
	}

	private function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
    }

    public function delete(): void
	{
		$sql = 'DELETE FROM `' . static::getTableName() . '` WHERE `id` = :id;';
	    $db = Db::getInstance();
		$db->query($sql, [':id' => $this->id], static::class);

		$this->id = null;
	}

	private function mapPropertiesToDbFormat(): array
	{
		$reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();
        
        $mappedProperties = [];
        foreach ($properties as $property) {
        	$propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }
        return $mappedProperties;
	}

	private function camelCaseToUnderscore(string $source): string
	{
		return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
	}
}