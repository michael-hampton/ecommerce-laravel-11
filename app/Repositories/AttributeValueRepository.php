<?php

namespace App\Repositories;

use App\Models\AttributeValue;
use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IAttributeValueRepository;

class AttributeValueRepository extends BaseRepository implements IAttributeValueRepository
{

    public function __construct(AttributeValue $attributeValue) {
        parent::__construct($attributeValue);
    }
}
