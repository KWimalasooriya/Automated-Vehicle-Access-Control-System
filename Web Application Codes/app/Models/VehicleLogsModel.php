<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleLogsModel extends Model
{
    protected $table = 'vehicle_logs'; // Table name
    protected $primaryKey = 'id'; // Primary key

    protected $allowedFields = [
        'vehicle_id',
        'entry_time',
        'exit_time',
        'direction'
    ]; // Fields that can be updated or inserted

    // Add additional functions if needed
    public function getLogs()
    {
        return $this->findAll();
    }

    public function getLogsByVehicleId($vehicleId)
    {
        return $this->where('vehicle_id', $vehicleId)->findAll();
    }
}
