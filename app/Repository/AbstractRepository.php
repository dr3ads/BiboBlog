<?php namespace BiboBlog\Repository;

use BiboBlog\Repository\RepositoryInterface;

/**
 * Class Repository
 * @package Bosnadev\Repositories\Eloquent
 */
abstract class AbstractRepository implements RepositoryInterface
{

    /**
     * @var
     */
    protected $model;

    /**
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'))
    {
        return $this->model->all();
    }

    /**
     * @param int $perPage
     * @param array $columns
     * @return mixed
     */
    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @param $id
     * @param string $attribute
     * @return mixed
     */
    public function update(array $data, $id, $attribute = "id")
    {
        return $this->model->where($attribute, '=', $id)->update($data);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function softDelete($id)
    {
        $item = $this->find($id);

        return $item->delete();
    }

    /**
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $columns
     * @return mixed
     */
    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    /**
     * Method to retrieve a key value pair
     *
     * @param $column
     * @param string $key_column
     * @return array
     */
    public function getValueByKey($column, $key_column = '')
    {
        if (!$key_column) {
            $key_column = $this->model->getKeyName();
        }

        $list = $this->model->all();

        $data = [];

        foreach ($list as $row) {
            $data[$row->{$key_column}] = $row->{$column};
        }

        return $data;
    }

    /**
     * @return $this
     */
    public function newQuery()
    {
        $this->model = $this->model->newQuery();
        return $this;
    }

    /**
     * @param $relations
     * @return $this
     */
    public function with($relations) {
        if (is_string($relations)) $relations = func_get_args();

        $this->with = $relations;

        return $this;
    }

    protected function eagerLoadRelations() {
        if(!is_null($this->with)) {
            foreach ($this->with as $relation) {
                $this->model->with($relation);
            }

            //$this->model->with(implode(',',$this->with));
        }
        return $this;
    }
}