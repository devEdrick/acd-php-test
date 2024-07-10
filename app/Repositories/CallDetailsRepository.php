<?php

namespace App\Repositories;

use App\Models\CallDetails;

/**
 * Class CallDetailsRepository
 *
 * This class provides an interface to interact with CallDetails model.
 */
class CallDetailsRepository
{
    protected CallDetails $model;

    /**
     * CallDetailsRepository constructor.
     */
    public function __construct()
    {
        $this->model = new CallDetails();
    }

    /**
     * Retrieve all call details for a given Call ID.
     *
     * @param int $callId The ID of the call.
     * @return array The list of call details.
     */
    public function get(int $callId): array
    {
        return $this->model->get($callId);
    }

    /**
     * Find a specific call detail by its ID.
     *
     * @param int $id The ID of the call detail.
     * @return array|null The call detail or null if not found.
     */
    public function find(int $id): ?array
    {
        return $this->model->find($id);
    }

    /**
     * Create a new call detail.
     *
     * @param array $data The data for the new call detail.
     * @return bool True on success, false otherwise.
     */
    public function create(array $data): bool
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing call detail.
     *
     * @param int $id The ID of the call detail to update.
     * @param array $data The updated data.
     * @return bool True on success, false otherwise.
     */
    public function update(int $id, array $data): bool
    {
        return $this->model->update($id, $data);
    }

    /**
     * Delete a specific call detail.
     *
     * @param int $id The ID of the call detail to delete.
     * @return bool True on success, false otherwise.
     */
    public function delete(int $id): bool
    {
        return $this->model->delete($id);
    }
}
