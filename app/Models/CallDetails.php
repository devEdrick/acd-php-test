<?php

namespace App\Models;

use App\Helpers\Database;
use PDO;
use PDOException;

/**
 * Class CallDetails
 * 
 * Manages CRUD operations for call details.
 */
class CallDetails
{
    protected PDO $db;
    protected string $table = 'Call_Details';

    /**
     * CallDetails constructor.
     *
     * @param PDO|null $db Database connection instance.
     */
    public function __construct(PDO $db = null)
    {
        $this->db = $db ?? Database::getConnection();
    }

    /**
     * Retrieves all call details for a specific call ID.
     *
     * @param int $callId The call ID.
     * @return array The call details.
     */
    public function get(int $callId): array
    {
        $query = "SELECT * FROM {$this->table} WHERE Callid = :callId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':callId', $callId, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result ?: [];
    }

    /**
     * Finds a specific call detail by its ID.
     *
     * @param int $detailId The detail ID.
     * @return array|null The call detail or null if not found.
     */
    public function find(int $detailId): ?array
    {
        $query = "SELECT * FROM {$this->table} WHERE DetailID = :detailId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':detailId', $detailId, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    /**
     * Creates a new call detail.
     *
     * @param array $data The call detail data.
     * @return bool True on success, false on failure.
     */
    public function create(array $data): bool
    {
        $query = "INSERT INTO {$this->table} (Callid, Date, Details, Hours, Minutes)
                  VALUES (:Callid, :Date, :Details, :Hours, :Minutes)";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':Callid', $data['Callid'], PDO::PARAM_INT);
        $stmt->bindParam(':Date', $data['Date']);
        $stmt->bindParam(':Details', $data['Details']);
        $stmt->bindParam(':Hours', $data['Hours'], PDO::PARAM_INT);
        $stmt->bindParam(':Minutes', $data['Minutes'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Updates an existing call detail.
     *
     * @param int $id The detail ID.
     * @param array $data The call detail data.
     * @return bool True on success, false on failure.
     */
    public function update(int $id, array $data): bool
    {
        $query = "UPDATE {$this->table} SET Date = :Date, Details = :Details, Hours = :Hours, Minutes = :Minutes
                  WHERE DetailID = :detailId";
        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':detailId', $id, PDO::PARAM_INT);
        $stmt->bindParam(':Date', $data['Date']);
        $stmt->bindParam(':Details', $data['Details']);
        $stmt->bindParam(':Hours', $data['Hours'], PDO::PARAM_INT);
        $stmt->bindParam(':Minutes', $data['Minutes'], PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Deletes a call detail.
     *
     * @param int $id The detail ID.
     * @return bool True on success, false on failure.
     */
    public function delete(int $id): bool
    {
        $query = "DELETE FROM {$this->table} WHERE DetailID = :detailId";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':detailId', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
