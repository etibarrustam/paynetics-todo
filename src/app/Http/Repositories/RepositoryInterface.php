<?php

namespace App\Http\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Model as ModelAlias;

/**
 * Interface RepositoryInterface.
 * @package App\Http\Repositories
 */
interface RepositoryInterface
{
    /**
     * Show all records.
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Find entity by id.
     * @param int $id
     * @return Model
     */
    public function getById(int $id): Model;

    /**
     * Create new entity.
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Bulk create.
     * @param array $data
     * @return Collection
     */
    public function createMany(array $data): Collection;

    /**
     * Update entity by id.
     * @param int $id
     * @param array $data
     * @return ModelAlias
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete entity by id.
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Get model instance.
     * @return ModelAlias
     */
    public function getModel(): Model;

    /**
     * Set model.
     * @param ModelAlias $model
     * @return $this
     */
    public function setModel(Model $model): static;

    /**
     * Create new Repository instance.
     * @param string $model
     * @return static
     */
    public static function make(string $model): static;
}
