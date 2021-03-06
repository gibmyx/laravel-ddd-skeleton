<?php

declare(strict_types=1);

namespace Medine\ERP\Items\Application\Response;

final class ItemResponse
{
    private $id;
    private $code;
    private $name;
    private $reference;
    private $type;
    private $categoryId;
    private $state;
    private $averageCost;
    private $companyId;

    public function __construct(
        string $id,
        string $code,
        string $name,
        ?string $reference,
        string $type,
        string $categoryId,
        string $state,
        float $averageCost,
        string $companyId
    )
    {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->reference = $reference;
        $this->type = $type;
        $this->categoryId = $categoryId;
        $this->state = $state;
        $this->averageCost = $averageCost;
        $this->companyId = $companyId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function reference(): ?string
    {
        return $this->reference;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function categoryId(): string
    {
        return $this->categoryId;
    }

    public function state(): string
    {
        return $this->state;
    }

    public function averageCost(): float
    {
        return $this->averageCost;
    }

    public function companyId(): string
    {
        return $this->companyId;
    }
}
