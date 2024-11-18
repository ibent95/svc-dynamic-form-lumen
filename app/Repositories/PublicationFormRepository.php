<?php

/**
 * Repository for Publication entity
 */

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\PublicationFormModel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PublicationFormRepository implements RepositoryInterface
{
    private PublicationFormModel $model;
    private int $count;
    private mixed $results;

    public function __construct(PublicationFormModel $model) {
        $this->model = $model;
        $this->count = 0;
        $this->results = null;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @return EloquentCollection<PublicationFormModel>
     */
    public function getAll(array $params = []): EloquentCollection
    {
        $this->results = $this->model::where($params);

        $this->count = $this->results->count();

        return $this->results->get();
    }

    public function getById(mixed $id, array $params = [], array $with = []): PublicationFormModel
    {
        $this->results = $this->model::with($with)
            ->where($id)
            ->where($params);

        return $this->results->first();
    }

    public function getByUuid(string $uuid, array $params = [], array $with = []): PublicationFormModel
    {
        $this->results = $this->model::with($with)
            ->where('uuid', $uuid)
            ->where($params);

        return $this->results->first();
    }

    public function create(array $itemDetails): void
    {
        // code
    }

    public function updateById(mixed $id, array $newItemDetails): void
    {
        // code
    }

    public function deleteById(mixed $id): void
    {
        // code
    }

}
