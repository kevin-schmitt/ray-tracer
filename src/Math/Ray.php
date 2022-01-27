<?php

declare(strict_types=1);

namespace RayTracer\Math;

use RayTracer\Model\Tuple;

final class Ray
{
   public function __construct(private Tuple $origin, private Tuple $direction)
   {}

   public static function from(Tuple $origin, Tuple $direction) : self
   {
       return new self($origin, $direction);
   }

   public function equalTo(self $that) : bool
   {
       if(false === $this->origin->equalTo($that->origin())) {
           return false;
       }

       if(false === $this->direction->equalTo($that->direction())) {
           return false;
       }

       return true;
   }

   public function origin() : Tuple
   {
       return $this->origin;
   }

   public function direction() : Tuple
   {
       return $this->direction;
   }

    /**
     * @throws RuntimeException
    */
   public function position(float $position) : Tuple
   {
       return $this->origin->plus($this->direction->multiplyBy($position));
   }
}
