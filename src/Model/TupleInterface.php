<?php

namespace RayTracer\Model;

interface TupleInterface {
	function getX() : float ;
	function getY() : float ;
	function getZ() : float ;
	function getW() : float ;
	function getType() : string;
}