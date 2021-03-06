<?php

declare(strict_types=1);

namespace Medine\ERP\Clients\Domain\Contracts;

use Medine\ERP\Clients\Domain\Entity\Client;
use Medine\ERP\Clients\Domain\ValueObjects\ClientId;

interface ClientRepository
{
    public function find(ClientId $id): ?Client;
    public function save(Client $client): void;
    public function savePhones(Client $client): void;
    public function saveEmails(Client $client): void;
    public function update(Client $client): void;
    public function matching(\Medine\ERP\Shared\Domain\Criteria $criteria): array;
}
