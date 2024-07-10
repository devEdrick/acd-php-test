<?php

namespace App\Controllers;

use App\Repositories\CallDetailsRepository;
use App\Repositories\CallRepository;
use Exception;

/**
 * Class CallDetailsController
 *
 * Manages CRUD operations for Call Details.
 */
class CallDetailsController
{
    protected CallRepository $callRepository;
    protected CallDetailsRepository $callDetailRepository;

    /**
     * CallDetailsController constructor.
     */
    public function __construct()
    {
        $this->callRepository = new CallRepository();
        $this->callDetailRepository = new CallDetailsRepository();
    }

    /**
     * Displays the form for creating a new call detail.
     *
     * @param int $callId The ID of the call.
     */
    public function create(int $callId)
    {
        $callHeader = $this->callRepository->find($callId);
        require_once __DIR__ . '/../../resources/views/call_details/create.php';
    }

    /**
     * Displays the form for editing a call detail.
     *
     * @param int $callId The ID of the call.
     * @param int $id The ID of the call detail.
     */
    public function edit(int $callId, int $id)
    {
        $callHeader = $this->callRepository->find($callId);
        $callDetail = $this->callDetailRepository->find($id);
        require_once __DIR__ . '/../../resources/views/call_details/edit.php';
    }

    /**
     * Stores a new call detail.
     *
     * @param int $callId The ID of the call.
     */
    public function store(int $callId)
    {
        $data = [
            'Callid' => $callId,
            'Date' => $_POST['date'],
            'Details' => $_POST['details'],
            'Hours' => $_POST['hours'],
            'Minutes' => $_POST['minutes'],
        ];

        try {
            $this->validateHoursAndMinutes($data['Hours'], $data['Minutes']);

            $this->callDetailRepository->create($data);

            $this->callRepository->updateTotalTime($callId);

            header("Location: /calls/{$callId}");
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $callHeader = $this->callRepository->find($callId);
            $callDetail = $data;
            require_once __DIR__ . '/../../resources/views/call_details/create.php';
        }
    }

    /**
     * Updates an existing call detail.
     *
     * @param int $callId The ID of the call.
     * @param int $id The ID of the call detail.
     */
    public function update(int $callId, int $id)
    {
        $data = [
            'Date' => $_POST['date'],
            'Details' => $_POST['details'],
            'Hours' => $_POST['hours'],
            'Minutes' => $_POST['minutes'],
        ];

        try {
            $this->validateHoursAndMinutes($data['Hours'], $data['Minutes']);

            $this->callDetailRepository->update($id, $data);

            $this->callRepository->updateTotalTime($callId);

            header("Location: /calls/{$callId}");
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $callHeader = $this->callRepository->find($callId);
            $callDetail = $data;
            $callDetail['Callid'] = $callId;
            $callDetail['DetailID'] = $id;
            require_once __DIR__ . '/../../resources/views/call_details/edit.php';
        }
    }

    /**
     * Deletes a call detail.
     *
     * @param int $callId The ID of the call.
     * @param int $id The ID of the call detail.
     */
    public function delete(int $callId, int $id)
    {
        $this->callDetailRepository->delete($id);

        $this->callRepository->updateTotalTime($callId);

        header("Location: /calls/{$callId}");
        exit;
    }

    /**
     * Validates the hours and minutes.
     *
     * @param int $hours The hours.
     * @param int $minutes The minutes.
     * @throws Exception If hours or minutes are invalid.
     */
    protected function validateHoursAndMinutes(int $hours, int $minutes)
    {
        if ($hours < 0 || $hours > 24) {
            throw new Exception('Hours must be between 0 and 24.');
        }

        if ($minutes < 0 || $minutes > 59) {
            throw new Exception('Minutes must be between 0 and 59.');
        }
    }
}
