<?php

declare(strict_types=1);

namespace Medine\ERP\Company\Infrastructure;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Medine\ERP\Company\Domain\CompanyHasUser;
use Medine\ERP\Company\Domain\CompanyHasUserRepository;

final class MySqlCompanyHasUserRepository implements CompanyHasUserRepository
{

    public function save(CompanyHasUser $companyHasUser): void
    {
        DB::table('companies')->insert([
            'id' => $companyHasUser->id(),
            'company_id' => $companyHasUser->companyId(),
            'user_id' => $companyHasUser->userId(),
            'rol_id' => $companyHasUser->rolId(),
            'status' => $companyHasUser->status(),
            'created_at' => $companyHasUser->createdAt(),
            'updated_at' => $companyHasUser->updatedAt()
        ]);
    }
}
