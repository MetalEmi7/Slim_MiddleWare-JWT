<?php 

interface IGenericDAO{ 
	
   	public function getById($request, $response, $args); 
   	public function getAll($request, $response, $args); 
   	public function insert($request, $response, $args);
   	public function delete($request, $response, $args);
   	public function update($request, $response, $args);

}