<?php declare(strict_types=1);

namespace RayTracer\Model;

use RayTracer\Enum\TypeTuple;

class Tuple implements TupleInterface { 
    public function __construct(
        private float $x,
        private float $y,
        private float $z,
        private float $w
    ) {}

	function getX() : float { 
 		return $this->x; 
	} 

	function getY() : float { 
 		return $this->y; 
	} 

	function getZ() : float { 
 		return $this->z; 
	} 

	function getW() : float { 
 		return $this->w; 
	} 

	function getType() : string { 
 		return TypeTuple::TYPES[$this->w]; 
	} 
}