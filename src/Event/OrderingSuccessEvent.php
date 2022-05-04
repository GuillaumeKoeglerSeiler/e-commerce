<?php

namespace App\Event;

use App\Entity\Ordering;
use Symfony\Contracts\EventDispatcher\Event;


class OrderingSuccessEvent extends Event
{
    private  $ordering;

    public function __construct(Ordering $ordering)
    {
        $this->ordering = $ordering;
    }


    public function getPurchase(): Ordering
    {
        return  $this->ordering;
    }
}