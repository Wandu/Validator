<?php
namespace Wandu\Validator\Testers;

use Wandu\Validator\Contracts\Tester;

class MaxTester implements Tester
{
    /** @var int */
    protected $max;

    /**
     * @param int $max
     */
    public function __construct($max)
    {
        $this->max = $max;
    }
    
    /**
     * {@inheritdoc}
     */
    public function test($data, $origin = null, array $keys = []): bool
    {
        if ($data === null) return false;
        return $data <= $this->max;
    }
}
