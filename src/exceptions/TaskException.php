<?php

namespace TaskForce\exceptions;

class TaskException extends \Exception
{
    public function __toString(): string
    {
        return $this->getMessage();
    }
}
