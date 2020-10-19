<?php

declare(strict_types=1);

namespace BroadwayDemo\ReadModel;

use Broadway\ReadModel\Projector;
use Broadway\ReadModel\Repository;
use BroadwayDemo\Basket\BasketCheckedOut;

class TotalProductsSoldProjector extends Projector
{
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    protected function applyBasketCheckedOut(BasketCheckedOut $event)
    {
        foreach ($event->getProducts() as $productId => $count) {
            $readModel = $this->getReadModel((string) $productId);

            $this->addProducts($readModel, $count);

            $this->repository->save($readModel);
        }
    }

    private function getReadModel($productId): TotalProductsSold
    {
        $readModel = $this->repository->find($productId);

        if (null === $readModel) {
            $readModel = new TotalProductsSold($productId);
        }

        return $readModel;
    }

    private function addProducts(TotalProductsSold $readModel, int $count)
    {
        $readModel->addProduct($count);
    }
}
