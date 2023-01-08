<?php
/**
 * Copyright © Interview_Task All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Interview\Task\Block\Index;

use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Catalog\Helper\Output as OutputHelper;
use Magento\Framework\Data\Helper\PostHelper; 
use Magento\Catalog\Block\Product\Context;
use Magento\Catalog\Model\Layer\Resolver;
use Magento\Framework\Url\Helper\Data;

class Index extends \Magento\Catalog\Block\Product\ListProduct
{

    /**
     * Constructor
     *
     * @param \Magento\Framework\View\Element\Template\Context  $context
     * @param array $data
     */
    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        PostHelper $postDataHelper,
        Resolver $layerResolver,
        Context $context,
        Data $urlHelper,
        array $data = [],
        ?OutputHelper $outputHelper = null  

    ) {
        parent::__construct($context, $postDataHelper, $layerResolver, $categoryRepository, $urlHelper, $data, $outputHelper);
    }

    public function _getProductCollection() {

        $productCollection = parent::_getProductCollection();

        // Filter the today created product only. consider as a new product.
        $todayStartOfDayDate = $this->_localeDate->date()->setTime(0, 0, 0)->format('Y-m-d H:i:s');
        $todayEndOfDayDate = $this->_localeDate->date()->setTime(23, 59, 59)->format('Y-m-d H:i:s');
        $productCollection->addAttributeToFilter('created_at', array('from' => $todayStartOfDayDate, 'to' => $todayEndOfDayDate));
    
        return $productCollection;
    }
}
