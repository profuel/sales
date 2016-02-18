<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\Sales\Business\Model;

use Generated\Shared\Transfer\CommentTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrderComment;
use Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface;

class CommentManager
{

    /**
     * @var \Spryker\Zed\Sales\Persistence\SalesQueryContainer
     */
    protected $queryContainer;

    /**
     * @param \Spryker\Zed\Sales\Persistence\SalesQueryContainerInterface $salesQueryContainer
     */
    public function __construct(SalesQueryContainerInterface $salesQueryContainer)
    {
        $this->queryContainer = $salesQueryContainer;
    }

    /**
     * @param \Generated\Shared\Transfer\CommentTransfer $commentTransfer
     *
     * @return \Orm\Zed\Sales\Persistence\SpySalesOrderComment
     */
    public function saveComment(CommentTransfer $commentTransfer)
    {
        $commentEntity = new SpySalesOrderComment();
        $commentEntity->fromArray($commentTransfer->toArray());

        $commentEntity->save();

        $commentTransfer->fromArray($commentEntity->toArray(), true);

        return $commentTransfer;
    }

}
