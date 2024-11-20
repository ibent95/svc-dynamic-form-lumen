<?php

/**
 * Repository for Publication entity
 */

namespace App\Repositories;

use App\Interfaces\RepositoryInterface;
use App\Models\PublicationFormVersionModel;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class PublicationFormVersionRepository implements RepositoryInterface
{
    private PublicationFormVersionModel $model;
    private int $count;
    private mixed $results;

    public function __construct(PublicationFormVersionModel $model) {
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
     * @return EloquentCollection<PublicationFormVersionModel>
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
    ): PublicationFormVersionModel
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
    ): PublicationFormVersionModel
    {
        $this->results = $this->model::with($with)
            ->where('uuid', $uuid)
            ->where($params);

        return $this->results->first();
    }

    public function create(array $itemDetails): PublicationFormVersionModel
    {
        $this->results = $this->model->saveOrFail();
        return $this->results;
    }

    public function updateById(mixed $id, array $newItemDetails): PublicationFormVersionModel
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
                'id_publication_type',
                'publication_form_version_name',
                'publication_form_version_code',
                'grid_system',
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
