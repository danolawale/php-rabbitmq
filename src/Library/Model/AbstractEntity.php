<?php

namespace Library\Model;

class AbstractEntity
{
    protected ?Adapter\AdapterServiceInterface $_adapter;
    public $isNew = true;
    protected $_fields = [];

   public function __construct(Adapter\AdapterServiceInterface $adapter = null)
   {
       $this->_adapter = $adapter ?? static::getRepository()::getAdapter();
   }

   public function __get($key)
	{
		return $this->_fields[ self::_validateField($key) ];
	}
	
	public function __set($key, $value)
	{
		$this->_fields[ self::_validateField($key) ] = $value;
	}

    public function getFields(): array
    {
        return $this->_fields;
    }

    public function save(array $data = null): EntityInterface
    {
        $data = $data ? $this->_validateEntityFields($data) : $this->_fields;

        if($this->isNew)
        {
            return $this->_createOne($data);
        }
        else
        {
            return $this->_updateOne($data);
        }
    }

    public function delete()
    {
        return $this->_deleteOne();
    }

    public static function init(array $data): EntityInterface
    {
        $entity = new static;

        foreach($data as $property => $value)
        {
            if(self::_validateField($property))
            {
                $entity->$property = $value;
            }
            else
            {
                throw new \Exception("Invalid property {$property} in entity {get_called_class()}");
            }
        }

        return $entity;
    }

    protected static function _validateField(string $key): string
	{
		$columns = static::$columns;
		
		if(!in_array($key, $columns))
		{
			throw new \Exception("Unable to access invalid field {$key} ");
		}
		
		return $key;
    }
    
    protected static function _validateFields(array $keys): array
    {
        $diff = array_diff($keys, static::$columns);

        if($diff)
        {
            $diff = implode(', ', $diff);

            throw new \Exception("Properties {$diff} not found in entity ". get_called_class());
        }

        return $keys;
    }

    protected function _validateEntityFields(array $data): array
    {
        if($this->_validateFields(array_keys($data)))
        {
            return $data;
        }
    }
}