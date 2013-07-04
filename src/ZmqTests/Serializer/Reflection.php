<?php
namespace ZmqTests\Serializer;

use ZmqTests\Exception\MessageUnserializeException;
use ZmqTests\SerializeMethod\SerializeMethod;
use ZmqTests\SerializableMessage;

class Reflection
{
    // @var SerializeMethod
    private $serializeMethod;

    // @var array
    private static $reflectors = array();

    /**
     * Constructor
     *
     * @param SerializeMethod $method
     */
    public function __construct(SerializeMethod $method)
    {
        $this->serializeMethod = $method;
    }
    
    /**
     * Serialize Message
     *
     * @param SerializableMessage $message
     * @return string
     */
    public function serialize(SerializableMessage $message)
    {
        $classProperties = $message->getProperties();
        $className = get_class($message);

        $reflector = $this->getReflectionClass($className);
        $reflectedProperties = $reflector->getProperties();

        $propertyValues = array();
        foreach ($reflectedProperties as $property) {
            $propertyName = $property->getName();

            if ($property->isProtected() || $property->isPrivate()) {
                $property->setAccessible(true);
            }

            if (in_array($propertyName, $classProperties)) {
                $propertyValues[$propertyName] = $property->getValue($message);
            }
        }

        return $this->serializeMethod->encode(array(
            'class' => $className,
            'properties' => $propertyValues,
        ));
    }

    /**
     * Unserialize Message
     *
     * @param array $messageString
     * @param SerializeMethod $method
     * @return SerializableMessage
     */
    public function unserialize($messageString, SerializeMethod $method)
    {
        $messageArray = $this->serializeMethod->decode($messageString);
        if (!is_array($messageArray)) {
            throw new MessageUnserializeException('Message is not in the correct format', $messageString);
        }

        if (!isset($messageArray['class']) || !is_string($messageArray['class'])) {
            throw new MessageUnserializeException('Message does not contain class identifier', $messageString);
        }

        $className = $messageArray['class'];
        if (!class_exists($className)) {
            throw new MessageUnserializeException(sprintf('Message class(%s) does not exist', $className), $messageString);
        }

        $propertyValues = $messageArray['properties'];

        $reflector = $this->getReflectionClass($className);
        $reflectedProperties = $reflector->getProperties();
        $classInstance = $reflector->newInstanceWithoutConstructor();
        $classProperties = $classInstance->getProperties();

        foreach ($reflectedProperties as $property) {
            $propertyName = $property->getName();

            if (!array_key_exists($propertyName, $propertyValues)) {
                throw new MessageUnserializeException(sprintf('Property \'%s\' does not exist in message', $propertyName), $messageString);
            }

            if ($property->isProtected() || $property->isPrivate()) {
                $property->setAccessible(true);
            }

            $property->setValue($classInstance, $propertyValues[$propertyName]);
        }
        
        return $classInstance;
    }

    /**
     * Get reflection class
     *
     * @param string $className
     * @return ReflectionClass
     */
    private function getReflectionClass($className)
    {
        if (!isset(self::$reflectors[$className])) {
            self::$reflectors[$className] = new \ReflectionClass($className);
        }

        return self::$reflectors[$className];
    }
}

