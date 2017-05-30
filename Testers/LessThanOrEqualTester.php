<?php
namespace Wandu\Validator\Testers;

class LessThanOrEqualTester extends PropertyTesterAbstract
{
    /**
     * {@inheritdoc}
     */
    public function test($data, $origin = null, array $keys = []): bool
    {
        if (null === $prop = $this->getProp($origin)) return false;
        return $prop >= $data;
    }
}
