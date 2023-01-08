<?php
/**
 * Copyright © Interview_Task All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Interview\Task\Controller\Index;

use Magento\Framework\App\Http\Context;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;

class Index implements HttpGetActionInterface
{

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param PageFactory $resultPageFactory
     */
    public function __construct (
        Context $context,
        PageFactory $resultPageFactory,
        SessionFactory $customerSession,
        RedirectFactory $redirectFactory
    ) {
        $this->context = $context;
        $this->resultPageFactory = $resultPageFactory;
        $this->customerSession = $customerSession;
        $this->redirectFactory = $redirectFactory;
    }

    /**
     * Execute view action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        if (!$this->customerSession->create()->isLoggedIn()) {

            // Redirect to login page 
            $resultRedirect = $this->redirectFactory->create();
            $resultRedirect->setPath('customer/account/create');
            return $resultRedirect;            

        } else {
            return $this->resultPageFactory->create();            
          }        
    }
}

