<?php

namespace App\Traits;

trait ResponsibleResourceTrait
{
    private string $message;
    private int $status;

    public function message(string $message): static
    {
        $this->additional['message'] = $message;

        return $this;
    }

    public function status(int $status): static
    {
        $this->additional['status'] = $status;

        return $this;
    }
}