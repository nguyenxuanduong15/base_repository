<?php

namespace Laravel\BaseRepository;

interface BaseRepositoryInterface
{
    public function boot();
    public function getAll();
    public function findById($id, $column = ['*']);
    public function delete($condition);
    public function insert($data);
    public function getQueryByConditions($conditions = []);
    public function updateDataWithConditions($updateData, $conditions);
    public function getDataWithConditions($selectData, $conditions, $orders = [], $limit = 0, $joins = [], $from = null);
}