<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as ModelAlias;

/**
 * class Repository
 * @package App\Http\Repositories
 */
class Repository implements RepositoryInterface
{
    /**
     * @var Model
     */
    private Model $model;

    /**
     * @param ModelAlias $model
     */
    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->getModel()->all();
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): Model
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function create(array $data): Model
    {
        return $this->getModel()->create($data);
    }

    /**
     * @inheritDoc
     */
    public function createMany(array $data): Collection
    {
        return $this->getModel()->insert($data);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $data): Model
    {
        $model = $this->getModel()->findOrFail($id);

        $model->fill($data);
        $model->save();

        return $model;
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return $this->getById($id)->delete();
    }

    /**
     * @inheritDoc
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @inheritDoc
     */
    public function setModel(Model $model): static
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public static function make(string $model): static
    {
        return new static(new $model());
    }
}
