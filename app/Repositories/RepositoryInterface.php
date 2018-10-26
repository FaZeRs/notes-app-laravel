<?php

namespace App\Repositories;

interface RepositoryInterface
{
    /**
     * Get all the model records in the database.
     *
     * @param  array $columns
     * @return \Illuminate\Support\Collection
     */
    public function all(array $columns = ['*']);

    /**
     * Create a new model record in the database.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function create(array $data);

    /**
     * Force create a new model and return the instance.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceCreate(array $data);

    /**
     * Update the specified model record in the database.
     *
     * @param  array $data
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function update($id, array $data);

    /**
     * Force update the specified model record in the database..
     *
     * @param  mixed $id
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceUpdate($id, array $data);

    /**
     * Delete the specified model record from the database.
     *
     * @param  mixed $id
     * @return bool|null
     * @throws \Throwable
     */
    public function delete($id);

    /**
     * Restore a soft-deleted model instance.
     *
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     * @throws \Throwable
     */
    public function restore($id);

    /**
     * Force a hard delete on a soft deleted model.
     *
     * @param  mixed $id
     * @return bool|null
     * @throws \Throwable
     */
    public function forceDelete($id);

    /**
     * Find a model by its primary key.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, array $columns = ['*']);

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, array $columns = ['*']);
}
