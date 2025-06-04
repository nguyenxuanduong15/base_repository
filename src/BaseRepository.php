<?php

namespace DuongNX\BaseRepository;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    abstract protected function getModel();

    public function __construct()
    {
        $this->setModel();
        $this->boot();
    }

    public function boot(): void
    {

    }

    /**
     * Set Model
     *
     * @return void
     */
    public function setModel(): void
    {
        $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get all record
     *
     * @return mixed
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * @param $id
     * @param $column
     * @return mixed
     */
    public function findById($id, $column = ['*'])
    {
        return $this->model->where("id", $id)->first($column);
    }

    /**
     * @param $condition
     * @return mixed
     */
    public function delete($condition)
    {
        $query = $this->model->newQuery();
        if (!is_array($condition)) {
            return $query->where("id", $condition)->delete();
        }
        foreach ($condition as $key => $value) {
            $query->where($key, $value);
        }
        return $query->delete();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return $this->model->create($data);
    }

    /**
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        return $this->model->insert($data);
    }

    /**
     * @param $conditions
     * @return null
     */
    public function getQueryByConditions($conditions = [])
    {
        if (empty($conditions)) {
            return null;
        }
        $query = $this->model->newQuery();
        $keys = $this->model->getKeyName();
        if (!is_array($keys)) {
            if (!isset($conditions[$keys])) {
                return null;
            } elseif (!is_array($conditions[$keys])) {
                return $query->where($keys, $conditions[$keys]);
            } else {
                return $query->whereIn($keys, $conditions[$keys]);
            }
        }

        foreach ($keys as $key) {
            if (!isset($conditions[$key])) {
                continue;
            }
            if (!is_array($conditions[$key])) {
                $query->where($key, $conditions[$key]);
            } else {
                $query->whereIn($key, $conditions[$key]);
            }
        }
        return $query;
    }

    /**
     * @param $updateData
     * @param $conditions
     * @return mixed
     */
    public function updateDataWithConditions($updateData, $conditions)
    {
        if (isset($conditions['no_change_timestamps_flag'])) {
            if ($conditions['no_change_timestamps_flag']) {
                $this->model->timestamps = false;
            }
            unset($conditions['no_change_timestamps_flag']);
        }

        $query = $this->model;
        foreach ($conditions as $condition => $value) {
            if (is_array($value) && !empty($value)) {
                $query = $query->whereIn($condition, $value);
            } else {
                $query = $query->where($condition, $value);
            }
        }
        return $query->update($updateData);
    }

    /**
     * @param $selectData
     * @param $conditions
     * @param $orders
     * @param $limit
     * @param $joins
     * @param $from
     * @return mixed
     */
    public function getDataWithConditions($selectData, $conditions, $orders = [], $limit = 0, $joins = [], $from = null)
    {
        $query = $this->model->select($selectData);
        if (!empty($from)) {
            $query = $query->from($from);
        }

        foreach ($joins as $join) {
            if (isset($join['table']) && isset($join['condition']) && is_array($join['condition'])) {
                $table = $join['table'];
                $condition = $join['condition'];
                $type = @$join['type'] ?: "join";
                $query->$type($table, function ($joinClause) use ($condition) {
                    foreach ($condition as $field => $value) {
                        if ($field === 'join_where') {
                            $k = array_key_first($value);
                            if (is_array($value[$k])) {
                                $joinClause->whereIn($k, $value[$k]);
                            } else {
                                $joinClause->where($k, '=', $value[$k]);
                            }
                        } else {
                            $joinClause->on($field, '=', $value);
                        }
                    }
                });
            }
        }

        foreach ($conditions as $condition => $value) {
            if ($condition && !empty($value) && is_array($value)) {
                $query->whereIn($condition, $value);
            } elseif (!$condition && !empty($value) && is_array($value)) {
                $query->where([$value]);
            } else {
                $query->where($condition, $value);
            }
        }

        foreach ($orders as $field => $dir) {
            if (is_numeric($field) && !empty($dir)) {
                $query->orderBy(strtolower($dir));
            }
            if (is_string($field) && in_array(strtolower($dir), ['desc', 'asc'])) {
                $query->orderBy(strtolower($field), strtolower($dir));
            }
        }

        if ($limit > 0) {
            return $query->limit($limit);
        }

        return $query;
    }
}