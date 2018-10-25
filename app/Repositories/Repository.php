<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository implements RepositoryInterface
{
    /**
     * The repository model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Array of related models to eager load.
     *
     * @var array
     */
    protected $with = [];

    /**
     * Instantiate a new repository instance.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Specify Model class name.
     *
     * @return mixed
     */
    abstract public function model();

    /**
     * @return Model
     * @throws \Exception
     */
    public function makeModel()
    {
        $model = app()->make($this->model());
        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of ".Model::class);
        }

        return $this->model = $model;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model instanceof Model ? clone $this->model : $this->model->getModel();
    }

    /**
     * Get a new query builder for the model's table.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function newQuery()
    {
        return $this->model instanceof Model ? $this->model->with($this->with)->newQuery() : clone $this->model;
    }

    /**
     * Create a new model instance that is existing.
     *
     * @param array $attributes
     * @param boolean $exists
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function newInstance($attributes = [], $exists = false)
    {
        return $this->getModel()->newInstance($attributes, $exists);
    }

    /**
     * Set Eloquent relationships to eager load.
     *
     * @param $relations
     * @return $this
     */
    public function with($relations)
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }
        $this->with = $relations;

        return $this;
    }

    /**
     * Get all the model records in the database.
     *
     * @param  array $columns
     * @return \Illuminate\Support\Collection
     */
    public function all(array $columns = ['*'])
    {
        return $this->newQuery()->get($columns);
    }

    /**
     * Create a new model record in the database.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function create(array $data)
    {
        return tap($this->newInstance(), function ($instance) use ($data) {
            $instance->fill($data)->saveOrFail();
        });
    }


    /**
     * Force create a new model and return the instance.
     *
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceCreate(array $data)
    {
        return tap($this->newInstance(), function ($instance) use ($data) {
            $instance->forceFill($data)->saveOrFail();
        });
    }

    /**
     * Update the specified model record in the database.
     *
     * @param  mixed $id
     * @param  array $data
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function update($id, array $data)
    {
        return tap($this->findOrFail($id), function ($instance) use ($data) {
            $instance->fill($data)->saveOrFail();
        });
    }

    /**
     * Force update the specified model record in the database..
     *
     * @param  array $data
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @throws \Throwable
     */
    public function forceUpdate($id, array $data)
    {
        return tap($this->findOrFail($id), function ($instance) use ($data) {
            $instance->forceFill($data)->saveOrFail();
        });
    }

    /**
     * Delete the specified model record from the database.
     *
     * @param  mixed $id
     * @return bool|null
     * @throws \Throwable
     */
    public function delete($id)
    {
        return $this->find($id)->delete();
    }

    /**
     * Restore a soft-deleted model instance.
     *
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function restore($id)
    {
        return $this->newQuery()->restore($id);
    }

    /**
     * Force a hard delete on a soft deleted model.
     *
     * @param  mixed $id
     * @return bool|null
     */
    public function forceDelete($id)
    {
        return $this->findOrFail($id)->forceDelete();
    }

    /**
     * Find a model by its primary key.
     *
     * @param  mixed $id
     * @param  array $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|static[]|static|null
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->newQuery()->find($id, $columns);
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, array $columns = ['*'])
    {
        return $this->newQuery()->findOrFail($id, $columns);
    }
}