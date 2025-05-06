<?php



namespace App\Repositories;

use App\Models\Courier;
use App\Repositories\Interfaces\ICourierRepository;

class CourierRepository extends BaseRepository implements ICourierRepository
{
    public function __construct(Courier $courier)
    {
        parent::__construct($courier);
    }
}
