<?php

/**
 * Repository for Publication entity
 */

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\PublicationGeneralTypeModel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PublicationGeneralTypeRepository implements RepositoryInterface
{
    private PublicationGeneralTypeModel $model;
    private int $count;
    private mixed $results;

    public function __construct(PublicationGeneralTypeModel $model) {
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
     * @return EloquentCollection<PublicationGeneralTypeModel>
     */
    public function getAll(array $params = []): EloquentCollection
    {
        $this->results = $this->model::where($params);

        $this->count = $this->results->count();

        return $this->results->get();
    }

    public function getById(
        mixed $id,
        array $params = [],
        array $with = []
    ): PublicationGeneralTypeModel
    {
        $this->results = $this->model::with($with)
            ->where($id)
            ->where($params);

        return $this->results->first();
    }

    public function getByUuid(
        string $uuid,
        array $params = [],
        array $with = []
    ): PublicationGeneralTypeModel
    {
        $this->results = $this->model::with($with)
            ->where('uuid', $uuid)
            ->where($params);

        return $this->results->first();
    }

    public function create(array $itemDetails): PublicationGeneralTypeModel
    {
        $this->results = $this->model->saveOrFail();
        return $this->results;
    }

    public function updateById(mixed $id, array $newItemDetails): PublicationGeneralTypeModel
    {
        $this->results = $this->model->saveOrFail();
        return $this->results;
    }

    public function upsert(array $newItemDetails)
    {
        $this->results = $this->model::upsert(
            $newItemDetails,
            uniqueBy: ['uuid'],
            update: [
                'id',
                'publication_general_type_name',
                'publication_general_type_code',
                'flag_active',
                'create_user',
                'created_at',
                'update_user',
                'updated_at',
                'uuid'
            ]
        );

        return $this->results;
    }

    public function deleteById(mixed $id): void
    {
        // code
    }

}
