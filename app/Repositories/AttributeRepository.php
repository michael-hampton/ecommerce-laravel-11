<?php

namespace App\Repositories;

use App\Models\Attribute;
use App\Models\ProductAttribute;
use App\Repositories\Interfaces\IBaseRepository;
use App\Repositories\Interfaces\IAttributeRepository;

class AttributeRepository extends BaseRepository implements IAttributeRepository
{

    public function __construct(ProductAttribute $attribute) {
        parent::__construct($attribute);
    }
}
