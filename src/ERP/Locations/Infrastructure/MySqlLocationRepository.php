<?php

declare(strict_types=1);

namespace Medine\ERP\Locations\Infrastructure;

use Illuminate\Support\Facades\DB;
use Medine\ERP\Locations\Domain\Entity\Location;
use Medine\ERP\Locations\Domain\LocationRepository;
use Medine\ERP\Shared\Infrastructure\MySqlRepository;

final class MySqlLocationRepository extends MySqlRepository implements LocationRepository
{

    public function save(Location $location): void
    {
        DB::table('locations')->insert([
            'id' => $location->id()->value(),
            'code' => $location->code()->value(),
            'name' => $location->name()->value(),
            'main_contact' => $location->mainContact()->value(),
            'barcode' => $location->barcode()->value(),
            'address' => $location->address()->value(),
            'item_State' => $location->itemState()->value(),
            'state' => $location->state()->value(),
            'company_id' => $location->companyId()->value(),
            'created_by' => $location->createdBy(),
            'updated_by' => $location->updatedBy(),
            'created_at' => $location->createdAt()->value(),
            'updated_at' => $location->updatedAt()->value(),
        ]);
    }
}
