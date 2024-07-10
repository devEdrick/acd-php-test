<?php

namespace App\Models;

use App\Helpers\Database;
use PDO;

class CallHeader
{
    protected PDO $db;
    protected string $table = 'Call_Header';

    public function __construct(PDO $db = null)
    {
        $this->db = $db ?? Database::getConnection();
    }

    /**
     * Retrieves Call_Header records based on optional filters.
     *
     * @param array $filters Optional filters to apply (e.g., ['UserName' => 'John', 'Date' => '2024-07-15']).
     * @return array Returns an array of Call_Header records.
     */
    public function get(array $filters = []): array
    {
        $query = "SELECT * FROM {$this->table}";

        if (!empty($filters)) {
            $query .= " WHERE ";

            $conditions = [];
            if (!empty($filters['UserName'])) {
                $conditions[] = "UserName = :UserName";
            }

            if (!empty($filters['Date'])) {
                $conditions[] = "Date = :Date";
            }

            $query .= implode(" AND ", $conditions);
        }

        $stmt = $this->db->prepare($query);

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Finds a Call_Header record by its Callid.
     *
     * @param int $callId The ID of the Call_Header record to find.
     * @return array|null Returns the Call_Header record as an associative array, or null if not found.
     */
    public function find(int $callId): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE Callid = :Callid");
        $stmt->bindParam(':Callid', $callId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Creates a new Call_Header record.
     *
     * @param array $data The data to insert into the Call_Header table.
     * @return bool Returns true on success, false on failure.
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("CALL Insert_Call(:Date, :ITPerson, :UserName, :Subject, :Details, :Status)");
        $stmt->bindParam(':Date', $data['Date']);
        $stmt->bindParam(':ITPerson', $data['ITPerson']);
        $stmt->bindParam(':UserName', $data['UserName']);
        $stmt->bindParam(':Subject', $data['Subject']);
        $stmt->bindParam(':Details', $data['Details']);
        $stmt->bindParam(':Status', $data['Status']);
        return $stmt->execute();
    }

    /**
     * Updates an existing Call_Header record.
     *
     * @param int $callId The ID of the Call_Header record to update.
     * @param array $data The data to update in the Call_Header table.
     * @return bool Returns true on success, false on failure.
     */
    public function update(int $callId, array $data): bool
    {
        $query = "UPDATE {$this->table} SET Date=:Date, ITPerson=:ITPerson, UserName=:UserName, Subject=:Subject, Details=:Details, Status=:Status WHERE Callid=:Callid";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':Callid', $callId);
        $stmt->bindParam(':Date', $data['Date']);
        $stmt->bindParam(':ITPerson', $data['ITPerson']);
        $stmt->bindParam(':UserName', $data['UserName']);
        $stmt->bindParam(':Subject', $data['Subject']);
        $stmt->bindParam(':Details', $data['Details']);
        $stmt->bindParam(':Status', $data['Status']);
        return $stmt->execute();
    }

    /**
     * Updates the total hours and minutes in Call_Header based on related Call_Details records.
     *
     * @param int $callId The ID of the Call_Header record to update.
     */
    public function updateTotalTime(int $callId): void
    {
        $sql = "SELECT SUM(Hours * 60 + Minutes) as TotalMinutes FROM Call_Details WHERE Callid = :callid";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':callid', $callId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $totalMinutes = $result['TotalMinutes'];
        $totalHours = floor($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;

        $updateSql = "UPDATE Call_Header SET Total_Hours = :totalHours, Total_Minutes = :remainingMinutes WHERE Callid = :callid";
        $updateStmt = $this->db->prepare($updateSql);
        $updateStmt->bindParam(':totalHours', $totalHours, PDO::PARAM_INT);
        $updateStmt->bindParam(':remainingMinutes', $remainingMinutes, PDO::PARAM_INT);
        $updateStmt->bindParam(':callid', $callId, PDO::PARAM_INT);
        $updateStmt->execute();
    }

    /**
     * Deletes a Call_Header record by its Callid.
     *
     * @param int $callId The ID of the Call_Header record to delete.
     * @return bool Returns true on success, false on failure.
     */
    public function delete(int $callId): bool
    {
        $stmt = $this->db->prepare("CALL Delete_Call(:Callid)");
        $stmt->bindParam(':Callid', $callId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
