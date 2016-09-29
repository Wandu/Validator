<?php
namespace Wandu\Validator\Rules;

use Wandu\Validator\Exception\InvalidValueException;
use function Wandu\Validator\validator;

class ArrayValidator extends ValidatorAbstract
{
    const ERROR_TYPE = 'array';
    
    /** @var \Wandu\Validator\Contracts\ValidatorInterface[] */
    protected $attributes = [];

    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $name => $validator) {
            $this->attributes[$name] = validator()->from($validator);
        }
    }

    /**
     * {@inheritdoc}
     */
    function test($item)
    {
        return is_array($item);
    }

    /**
     * {@inheritdoc}
     */
    public function assert($item)
    {
        if (!isset($item)) $item = [];
        /** @var \Wandu\Validator\Exception\InvalidValueException[] $exceptions */
        $exceptions = [];
        if (!$this->test($item)) {
            $exceptions['.'] = $this->createException();
        }
        foreach ($this->attributes as $name => $validator) {
            try {
                $validator->assert(isset($item[$name]) ? $item[$name] : null);
            } catch (InvalidValueException $e) {
                $exceptions[$name] = $e;
            }
        }
        if (count($exceptions)) {
            throw InvalidValueException::merge($exceptions);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate($item)
    {
        if (!isset($item)) $item = [];
        if (!$this->test($item)) return false;
        
        foreach ($this->attributes as $name => $validator) {
            if (!is_array($item) || !array_key_exists($name, $item)) {
                return false;
            }
            if (!$validator->validate($item[$name])) {
                return false;
            }
        }
        return true;
    }
}
