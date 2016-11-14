<?php

namespace Schema\Resolvers;


use Schema\Definition\Field;
use Schema\Definition\ModelFields\ModelField;

abstract class ModelResolver implements ResolverInterface
{
    protected function getModel(Field $field){

        if(!($field instanceof ModelField)){
            throw new \Exception("Field " . $field->getName() . " should be an instance of ModelField");
        }

        return $field->getModel();
    }
}