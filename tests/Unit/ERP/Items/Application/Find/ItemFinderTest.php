<?php

declare(strict_types=1);

namespace Tests\Unit\ERP\Items\Application\Find;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Medine\ERP\Items\Application\Find\ItemFinder;
use Medine\ERP\Items\Domain\Contracts\ItemRepository;
use Medine\ERP\Items\Domain\Entity\Item;
use Tests\TestCase;
use Tests\Unit\ERP\Items\Domain\ItemMother;

final class ItemFinderTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_should_find_an_existing_item()
    {
        $item = ItemMother::random();

        $repository = $this->createMock(ItemRepository::class);
        $this->shouldFind($repository, $item);

        $response = (new ItemFinder($repository))->__invoke(
            FindItemRequestMother::withId($item->id()->value())
        );

        $this->assertEquals($item->id()->value(), $response->id());
        $this->assertEquals($item->code()->value(), $response->code());
        $this->assertEquals($item->name()->value(), $response->name());
        $this->assertEquals($item->categoryId()->value(), $response->categoryId());
        $this->assertEquals($item->reference(), $response->reference());
        $this->assertEquals($item->type()->value(), $response->type());
    }

    private function shouldFind(\PHPUnit\Framework\MockObject\MockObject $repository, Item $item): void
    {
        $repository->method('find')
            ->with($this->equalTo($item->id()))
            ->willReturn($item);
    }
}
