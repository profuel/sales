<?php

/**
 * (c) Spryker Systems GmbH copyright protected
 */

namespace Spryker\Zed\Sales\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\CommentTransfer;
use Generated\Shared\Transfer\OrderListTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Spryker\Zed\Sales\Business\SalesBusinessFactory getFactory()
 */
class SalesFacade extends AbstractFacade
{

    /**
     * Specification:
     *  - Returns persisted order information stored into OrderTransfer
     *  - Aggregates order totals calls -> SalesAggregator
     *
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OrderTransfer
     */
    public function getOrderByIdSalesOrder($idSalesOrder)
    {
        return $this->getFactory()
            ->createOrderHydrator()
            ->hydrateOrderTransferFromPersistenceByIdSalesOrder($idSalesOrder);
    }

    /**
     * Specification:
     *  - Returns a list of of orders for the given customer id and (optional) filters.
     *  - Aggregates order totals calls -> SalesAggregator
     *
     * @param \Generated\Shared\Transfer\OrderListTransfer $orderListTransfer
     * @param int $idCustomer
     *
     * @return \Generated\Shared\Transfer\OrderListTransfer
     */
    public function getCustomerOrders(OrderListTransfer $orderListTransfer, $idCustomer)
    {
        return $this->getFactory()
            ->createCustomerOrderReader()
            ->getOrders($orderListTransfer, $idCustomer);
    }

    /**
     * Specification:
     * - Save order and items to database
     * - Set "is test" flag
     * - update checkout response with saved order data
     * - set initial state for state machine
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function saveOrder(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $this->getFactory()
            ->createOrderSaver()
            ->saveOrder($quoteTransfer, $checkoutResponseTransfer);
    }

    /**
     * Specification:
     * - Add username to comment
     * - Save comment to database
     *
     * @param \Generated\Shared\Transfer\CommentTransfer $commentTransfer
     *
     * @return \Generated\Shared\Transfer\CommentTransfer
     */
    public function saveComment(CommentTransfer $commentTransfer)
    {
        return $this->getFactory()
            ->createOrderCommentSaver()
            ->save($commentTransfer);
    }

    /**
     * Specification:
     * - Return the distinct states of all order items for the given order id
     *
     * @param int $idSalesOrder
     *
     * @return array|string[]
     */
    public function getDistinctOrderStates($idSalesOrder)
    {
        return $this->getFactory()
            ->createOrderReader()
            ->getDistinctOrderStates($idSalesOrder);
    }

    /**
     * Specification:
     * - Return all comments for the given order id
     *
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OrderDetailsCommentsTransfer
     */
    public function getOrderCommentsByIdSalesOrder($idSalesOrder)
    {
        return $this->getFactory()
            ->createOrderCommentReader()
            ->getCommentsByIdSalesOrder($idSalesOrder);
    }

    /**
     * Specification
     * - Update sales order with data from order transfer
     * - Returns true if order was successfully updated
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     * @param int $idSalesOrder
     *
     * @return bool
     */
    public function updateOrder(OrderTransfer $orderTransfer, $idSalesOrder)
    {
        return $this->getFactory()
            ->createOrderUpdater()
            ->update($orderTransfer, $idSalesOrder);
    }

    /**
     * Specification:
     * - Replaces all values of the order address by the values from the addresses transfer
     * - Returns true if order was successfully updated
     *
     * @param \Generated\Shared\Transfer\AddressTransfer $addressesTransfer
     * @param int $idAddress
     *
     * @return boolean
     */
    public function updateOrderAddress(AddressTransfer $addressesTransfer, $idAddress)
    {
        return $this->getFactory()
            ->createOrderAddressUpdater()
            ->update($addressesTransfer, $idAddress);
    }
}
