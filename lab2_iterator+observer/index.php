<?php

class NumbersIterator implements \Iterator
{
    private $collection;
    private $position = 0;
    private $reverse = false;

    public function __construct($collection, $reverse = false)
    {
        $this->collection = $collection;
        $this->reverse = $reverse;
    }

    public function rewind()
    {  
        $this->position = $this->reverse ?
            count($this->collection->getItems()) - 1 : 0;
    }

    public function current()
    {
        return $this->collection->getItems()[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        $this->position += ($this->reverse ? -1 : 1);
    }

    public function valid()
    {
        return isset($this->collection->getItems()[$this->position]);
    }
}

class NumbersCollection implements \IteratorAggregate
{
    private $items = [];

    public function __construct($array)
    {
        $this->items = $array;
    }

    public function getItems()
    {
        return $this->items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function getIterator(): Iterator
    {
        return new NumbersIterator($this);
    }

    public function getReverseIterator(): Iterator
    {
        return new NumbersIterator($this, true);
    }
}

class Numbers implements \SplSubject
{
    public $state;
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function logic(): void
    {
        $collection = new NumbersCollection(['1','2','3','4','5','6','7']);
        $collection->addItem("8");

        foreach ($collection->getIterator() as $item) {
            $this->state = $item;
            echo "State has just changed to: {$this->state}\n";
            $this->notify();
        }
    }
}

class EvenNumbersObserver implements \SplObserver
{
    public function update(\SplSubject $subject): void
    {
        if ($subject->state % 2 == 0) {
            echo "Even Numbers Observer reacted \n";
        }
    }
}

class OddNumbersObserver implements \SplObserver
{
    public function update(\SplSubject $subject): void
    {
        if ($subject->state % 2 !== 0) {
            echo "Odd Numbers Observer reacted \n";
        }
    }
}
$subject = new Numbers();

$evenNumberObserver = new EvenNumbersObserver();
$oddNumberObserver  = new OddNumbersObserver();

$subject->attach($evenNumberObserver);
$subject->attach($oddNumberObserver);

$subject->logic();
