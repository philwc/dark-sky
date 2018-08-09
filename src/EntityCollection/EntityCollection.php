<?php
declare(strict_types=1);

namespace philwc\DarkSky\EntityCollection;

use Assert\Assertion;
use Ds\Vector;
use philwc\DarkSky\Entity\EntityInterface;

/**
 * Class EntityCollection
 * @package philwc\DarkSky\EntityCollection
 */
abstract class EntityCollection implements \IteratorAggregate, \ArrayAccess
{
    private $collection;

    /**
     * EntityCollection constructor.
     */
    public function __construct()
    {
        $this->collection = new Vector();
    }

    /**
     * @param EntityCollection $collection
     * @throws \Assert\AssertionFailedException
     */
    public function merge(EntityCollection $collection)
    {
        Assertion::isInstanceOf($collection, $this->getCollectionClass());

        foreach ($collection as $item) {
            $this->add($item);
        }
    }

    /**
     * @param EntityInterface $entity
     * @throws \Assert\AssertionFailedException
     */
    public function add(EntityInterface $entity)
    {
        Assertion::isInstanceOf($entity, $this->getEntityClass());

        $this->collection->push($entity);
    }

    /**
     * @return Vector
     */
    public function all(): Vector
    {
        return $this->collection;
    }

    /**
     * @return EntityInterface
     */
    public function last(): EntityInterface
    {
        return $this->collection->last();
    }

    /**
     * @return EntityInterface
     */
    public function first(): EntityInterface
    {
        return $this->collection->first();
    }

    /**
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->collection->offsetExists($offset);
    }

    /**
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset): EntityInterface
    {
        return $this->collection->offsetGet($offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->collection->offsetSet($offset, $value);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $this->collection->offsetUnset($offset);
    }

    /**
     * @return \Generator
     */
    public function getIterator(): \Generator
    {
        foreach ($this->collection->toArray() as $value) {
            yield $value;
        }
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return $this->collection->count();
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return \call_user_func_array([$this->collection, $name], $arguments);
    }

    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    abstract protected function getCollectionClass(): string;

    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    /**
     * @return string
     */
    abstract protected function getEntityClass(): string;
}
