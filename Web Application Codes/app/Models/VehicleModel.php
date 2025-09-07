<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table = 'vehicles';
    protected $allowedFields = ['number_plate', 'authorized', 'user_id', 'post', 'gate_pass_issued'];

    public function getLatestVehicles()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT v.number_plate, v.authorized, v.user_id, v.post, v.gate_pass_issued,
                   vl.entry_time, vl.exit_time, vl.status
            FROM vehicles v
            LEFT JOIN vehicle_logs vl ON v.id = vl.vehicle_id
            ORDER BY vl.entry_time DESC
        ");

        return $query->getResultArray();
    }

    public function getLatestVisitors()
    {
        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT name, license_plate, purpose
            FROM visitors
            WHERE license_plate IN (SELECT number_plate FROM vehicles)
            ORDER BY registered_at DESC
        ");

        return $query->getResultArray();
    }
}
