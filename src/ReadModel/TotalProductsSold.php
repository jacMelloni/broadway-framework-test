<?php

declare(strict_types=1);

namespace BroadwayDemo\ReadModel;

use Broadway\ReadModel\SerializableReadModel;

class TotalProductsSold implements SerializableReadModel
{
    private $purchasedProductId;
    private $totalNumber;

    public function __construct(string $purchasedProductId)
    {
        $this->purchasedProductId = $purchasedProductId;
        $this->totalNumber = 0;
    }

    /**
     * {@inheritdoc}
     */
    public function getId(): string
    {
        return $this->purchasedProductId;
    }

    /**
     * {@inheritdoc}
     */
    public function serialize(): array
    {
        return [
            'purchasedProductId' => $this->purchasedProductId,
            'totalNumberOfProductsSold' => $this->totalNumber,
        ];
    }

    public function addProduct(int $count)
    {
        $this->totalNumber += $count;
    }

    /**
     * {@inheritdoc}
     */
    public static function deserialize(array $data)
    {
        $readModel = new self($data['purchasedProductId']);

        $readModel->totalNumber = $data['totalNumberOfProductsSold'];

        return $readModel;
    }

    public function numberOfTimesProductHasBeenPurchased(): int
    {
        return $this->totalNumber;
    }
}
