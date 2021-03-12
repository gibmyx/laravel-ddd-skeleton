<?php

declare(strict_types=1);

namespace Medine\ERP\Items\Infrastructure\Controller;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Medine\ERP\Items\Application\Create\ItemCreator;
use Medine\ERP\Items\Application\Create\ItemCreatorRequest;

final class ItemPostController
{
    private $creator;

    public function __construct(ItemCreator $creator)
    {
        $this->creator = $creator;
    }

    public function __invoke(Request $request)
    {
        ($this->creator)(new ItemCreatorRequest(
            $request->id,
            $request->name,
            $request->description,
            $request->state,
            $request->user()->id,
            $request->companyId
        ));

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}
