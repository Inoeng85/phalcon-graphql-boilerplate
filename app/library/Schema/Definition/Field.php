<?php

namespace Schema\Definition;

class Field
{

    protected $_name;

    protected $_description;

    protected $_type;

    protected $_nonNull;

    protected $_isList;

    protected $_isNonNullList;

    protected $_resolvers = [];

    protected $_args = [];

    public function name($name)
    {
        $this->_name = $name;
        return $this;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function description($description)
    {
        $this->_description = $description;
        return $this;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function type($type)
    {
        $this->_type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->_type;
    }

    public function nonNull($nonNull = true)
    {
        $this->_nonNull = $nonNull;
        return $this;
    }

    public function getNonNull()
    {
        return $this->_nonNull;
    }

    public function isList($isList = true)
    {
        $this->_isList = $isList;
        return $this;
    }

    public function getIsList()
    {
        return $this->_isList;
    }

    public function isNonNullList($isNonNullList = true)
    {
        $this->_isNonNullList = $isNonNullList;
        return $this;
    }

    public function getIsNonNullList()
    {
        return $this->_isNonNullList;
    }

    public function resolver($resolver)
    {
        $this->_resolvers[] = $resolver;
        return $this;
    }

    public function getResolvers()
    {
        return $this->_resolvers;
    }

    public function arg(InputField $inputField)
    {
        $this->_args[] = $inputField;
        return $this;
    }

    public function getArgs()
    {
        return $this->_args;
    }

    public static function factory()
    {
        return new Field;
    }
}
