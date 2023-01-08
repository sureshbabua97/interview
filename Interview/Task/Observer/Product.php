<?php
 
namespace Interview\Task\Observer;
 
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\QuoteFactory;

class Product implements ObserverInterface
{

    public function __construct(
        \Magento\Framework\Stdlib\CookieManagerInterface $cookieManager,
        QuoteFactory $quoteFactory
    ) {
        $this->cookieManager = $cookieManager;
        $this->quoteFactory = $quoteFactory;
    }

    /**
     * set the custom value on the quote
     * 
     * @param Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $event = $observer->getEvent();

        $quote = $event->getCart()->getQuote();
        
         if ($this->cookieManager->getCookie('first_name') && $this->cookieManager->getCookie('last_name')) {
             $quoteModel = $this->quoteFactory->create()->load($quote->getId()); 
             $quoteModel->setData('fname', $this->cookieManager->getCookie('first_name'));
             $quoteModel->setData('lname', $this->cookieManager->getCookie('last_name'));
             $quoteModel->save();
         }

    }
}
