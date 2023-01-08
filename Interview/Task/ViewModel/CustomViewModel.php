<?php

namespace Interview\Task\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;

class CustomViewModel implements ArgumentInterface
{
    public function __construct(
        \Magento\Sales\Api\OrderInterface  $orderInterface 
    ) {
        $this->orderInterface  = $orderInterface;
    }

    public function getcustomvalue($orderId)
    {
        $order = $this->OrderInterface->loadByIncrementId($incrementId);
        return $order;
    }
}