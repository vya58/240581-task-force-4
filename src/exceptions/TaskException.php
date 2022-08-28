<?php

namespace TaskForce\exceptions;

class TaskException extends \Exception {
public function __toString(): string
{
    //$message = $this->getMessage();
    return $this->getMessage();
}
}