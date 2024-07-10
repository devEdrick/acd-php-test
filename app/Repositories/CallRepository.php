<?php

namespace App\Repositories;

use App\Models\CallHeader;

/**
 * Class CallRepository
 *
 * This class provides an interface to interact with CallHeader model.
 */
class CallRepository
{
    protected CallHeader $model;

    /**
     * CallRepository constructor.
     */
    public function __construct()
    {
        $this->model = new CallHeader();
    }

    /**
     * Retrieve call headers based on optional filters.
     *
     * @param array $filters Optional filters for querying call headers.
     * @return array Array of call headers matching the filters.
     */
    public function get(array $filters = []): array
    {
        return $this->model->get($filters);
    }

    /**
     * Find a specific call header by its ID.
     *
     * @param int $id The ID of the call header.
     * @return array|null The call header data or null if not found.
     */
    public function find(int $id): ?array
    {
        return $this->model->find($id);
    }

    /**
     * Create a new call header.
     *
     * @param array $data The data for the new call header.
     * @return bool True on success, false otherwise.
     */
    public function create(array $data): bool
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing call header.
     *
     * @param int $id The ID of the call header to update.
     * @param array $data The updated data.
     * @return bool True on success, false otherwise.
     */
    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    /**
     * Update the total time (hours and minutes) for a call header.
     *
     * @param int $id The ID of the call header to update total time for.
     * @return void
     */
    public function updateTotalTime(int $id): void
    {
        $this->model->updateTotalTime($id);
    }

    /**
     * Delete a specific call header.
     *
     * @param int $id The ID of the call header to delete.
     * @return bool True on success, false otherwise.
     */
    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }
}
