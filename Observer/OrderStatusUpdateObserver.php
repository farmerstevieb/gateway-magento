<?php
/**
 * Copyright © 2022 PayU Financial Services. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace PayU\Gateway\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

/**
 * class OrderStatusUpdateObserver
 * @package PayU\Gateway\Observer
 */
class OrderStatusUpdateObserver implements ObserverInterface
{
    /**
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $event = $observer->getEvent();
        $payment = $event->getDataByKey('payment');
        $order = $payment->getOrder();

        if ($order->getIncrementId()) {
            $orderStatus = $payment->getMethodInstance()->getConfigData('order_status', $order->getStoreId());
            $order->setState($orderStatus);
            $order->setStatus($orderStatus);
            $order->setCanSendNewEmailFlag(false);
        }
    }
}
