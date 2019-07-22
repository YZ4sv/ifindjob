<?php

/**
 * Class Reader
 */
class Reader implements SeekableIterator
{
    /** @var resource */
    private $file;
    /** @var int  */
    public $offset = 10;
    /** @var int  */
    private $currentOffset = 0;

    /**
     * Reader constructor.
     * @param string $pathToFile
     */
    public function __construct(string $pathToFile)
    {
        $this->file = fopen($pathToFile, 'r');
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        fclose($this->file);
    }

    /**
     * @return bool|mixed|string
     */
    public function current()
    {
        $data = fgets($this->file, $this->offset);

        return $data;
    }

    /**
     * @return float|int|mixed
     */
    public function key()
    {
        return $this->currentOffset / $this->offset;
    }

    /**
     * return void
     */
    public function next()
    {
        $this->currentOffset += $this->offset;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->currentOffset = 0;

        fseek($this->file, $this->currentOffset);
    }

    /**
     * @param int $position
     */
    public function seek($position)
    {
        if (fseek($this->file, $position * $this->offset) === -1) {
            throw new OutOfBoundsException();
        }
    }

    /**
     * @return bool
     */
    public function valid()
    {
        return !feof($this->file);
    }
}