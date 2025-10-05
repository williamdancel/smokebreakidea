<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    protected $model;

    public function find($id): ?Model
    {
        // Convert to integer if it's a numeric string
        $id = is_numeric($id) ? (int) $id : $id;
        return $this->model->find($id);
    }

    public function findOrFail($id): Model
    {
        $id = is_numeric($id) ? (int) $id : $id;
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update($id, array $data): bool
    {
        $id = is_numeric($id) ? (int) $id : $id;
        $model = $this->find($id);
        return $model ? $model->update($data) : false;
    }

    public function delete($id): bool
    {
        $id = is_numeric($id) ? (int) $id : $id;
        $model = $this->find($id);
        return $model ? $model->delete() : false;
    }

    protected function successResponse($data = null, string $message = 'Success', int $code = 200)
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
            'code' => $code
        ];
    }

    protected function errorResponse(string $message = 'Error', int $code = 400, $errors = null)
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
            'code' => $code
        ];
    }
}