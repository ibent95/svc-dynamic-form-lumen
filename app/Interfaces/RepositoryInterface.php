<?php

namespace App\Interfaces;

interface RepositoryInterface
{
	public function getAll();
	public function getById(mixed $id);
	public function create(array $itemDetails);
	public function updateById(mixed $id, array $newItemDetails);
	public function deleteById(mixed $id);
}
