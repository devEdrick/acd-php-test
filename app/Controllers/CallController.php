<?php

namespace App\Controllers;

use App\Repositories\CallDetailsRepository;
use App\Repositories\CallRepository;

/**
 * Class CallController
 *
 * Controller for managing CRUD operations on Call_Header records.
 */
class CallController
{
    protected CallRepository $callRepository;
    protected CallDetailsRepository $callDetailsRepository;

    /**
     * CallController constructor.
     *
     * Initializes repositories for Call_Header and Call_Details.
     */
    public function __construct()
    {
        $this->callRepository = new CallRepository();
        $this->callDetailsRepository = new CallDetailsRepository();
    }

    /**
     * Displays a list of all Call_Header records.
     */
    public function index()
    {
        $filters = array_filter([
            'UserName' => $_GET['username'] ?? '',
            'fromDate' => $_GET['fromDate'] ?? '',
            'toDate' => $_GET['toDate'] ?? '',
        ]);
    
        $callHeaders = $this->callRepository->get($filters);
    
        require_once __DIR__ . '/../../resources/views/call_headers/index.php';
    }

    /**
     * Displays details of a specific Call_Header record.
     *
     * @param int $id The ID of the Call_Header record to display.
     */
    public function show(int $id)
    {
        $callHeader = $this->callRepository->find($id);
        $callDetails = $this->callDetailsRepository->get($id);
        require_once __DIR__ . '/../../resources/views/call_headers/show.php';
    }

    /**
     * Displays the form for creating a new Call_Header record.
     */
    public function create()
    {
        require_once __DIR__ . '/../../resources/views/call_headers/create.php';
    }

    /**
     * Displays the form for editing a specific Call_Header record.
     *
     * @param int $id The ID of the Call_Header record to edit.
     */
    public function edit(int $id)
    {
        $callHeader = $this->callRepository->find($id);
        require_once __DIR__ . '/../../resources/views/call_headers/edit.php';
    }

    /**
     * Handles the creation of a new Call_Header record.
     */
    public function store()
    {
        $data = [
            'Date' => $_POST['date'],
            'ITPerson' => $_POST['it_person'],
            'UserName' => $_POST['username'],
            'Subject' => $_POST['subject'],
            'Details' => $_POST['details'],
            'Status' => $_POST['status'],
        ];

        $this->callRepository->create($data);
        header('Location: /calls');
    }

    /**
     * Handles the update of a specific Call_Header record.
     *
     * @param int $id The ID of the Call_Header record to update.
     */
    public function update(int $id)
    {
        $data = [
            'Date' => $_POST['date'],
            'ITPerson' => $_POST['it_person'],
            'Subject' => $_POST['subject'],
            'Details' => $_POST['details'],
            'Status' => $_POST['status'],
        ];

        $this->callRepository->update($id, $data);
        header('Location: /calls');
    }

    /**
     * Handles the deletion of a specific Call_Header record.
     *
     * @param int $id The ID of the Call_Header record to delete.
     */
    public function delete(int $id)
    {
        $this->callRepository->delete($id);
        header('Location: /calls');
    }
}
