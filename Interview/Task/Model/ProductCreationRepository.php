<?php
/**
 * Copyright © Interview_Task All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Interview\Task\Model;

use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\Product\Option;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable\Attribute;
use Magento\ConfigurableProduct\Model\Product\Type\Configurable;

class ProductCreationRepository implements \Interview\Task\Api\ProductCreationInterface
{

    public function __construct(
        ProductFactory $productFactory,
        Option $option,
        Attribute $attribute,
        Configurable $configurable
     ) {
        $this->productFactory = $productFactory;
        $this->attribute = $attribute;
        $this->option = $option;
        $this->configurable = $configurable;
    }

    /**
     * {@inheritdoc}
     */
    public function simpleProduct()
    {
       

        $productDetails = [            
            [
                "product_name"  => "shirt",
                "product_sku"   => "shirt-123",
                "product_price" =>  9.99,
                "product_desc"  => "Product Description",
            ],
            [
                "product_name"  => "T-shirt",
                "product_sku"   => "T-shirt-124",
                "product_price" =>  10.00,
                "product_desc"  => "Product Description",
            ],
        ];

        try {

            foreach ($productDetails as $productDetail) {
                $product = $this->productFactory->create();
                $product->setName($productDetail['product_name']);
                $product->setSku($productDetail['product_sku']);
                $product->setPrice($productDetail['product_price']);
                $product->setDescription($productDetail['product_desc']);
                $product->setAttributeSetId(4);
                $product->setStatus(1);
                $product->setVisibility(4);

                $product->setTypeId(\Magento\Catalog\Model\Product\Type::TYPE_SIMPLE);
    
                $product->setStockData(
                    [
                        'use_config_manage_stock' => 1,
                        'manage_stock' => 1,
                        'is_in_stock' => 1,
                        'qty' => 100
                    ]
                );
        
                $product->save();
            }
    
        } catch (\Exception $e) {
            return [$e->getmessage()];
        }

        return ['product has created successfully'];
    }

    /**
     * {@inheritdoc}
     */
    public function configProduct()
    {
        $product = $this->productFactory->create();
        $product->setSku('my-sku');
        $product->setName('clothes');
        $product->setAttributeSetId(4);
        $product->setStatus(1);
        $product->setWeight(10);
        $product->setVisibility(4);
        $product->setTaxClassId(0);
        $product->setTypeId('simple');
        $product->setPrice(100);
        $product->setStockData(
                                array(
                                    'use_config_manage_stock' => 0,
                                    'manage_stock' => 1,
                                    'is_in_stock' => 1,
                                    'qty' => 999999999
                                )
                            );
        $product->save();

        $options = array(
            array(
                "sort_order"    => 1,
                "title"         => "Custom Option 1",
                "price_type"    => "fixed",
                "price"         => "10",
                "type"          => "field",
                "is_require"    =>   0
            ),
            array(
                "sort_order"    => 2,
                "title"         => "Custom Option 2",
                "price_type"    => "fixed",
                "price"         => "20",
                "type"          => "field",
                "is_require"   => 0
            )
        );

        foreach ($options as $arrayOption) {
        $product->setHasOptions(1);
        $product->getResource()->save($product);
        $option = $this->option->setProductId($product->getId())
                        ->setStoreId($product->getStoreId())
                        ->addData($arrayOption);
        $option->save();

        $product->addOption($option);
        }

        try { 
            $productId = $product->getId();
            $product = $this->productFactory->create()->load($productId); 
            $attributeModel = $this->attribute;
            $position = 0;
            $attributes = array(134, 135); 
            $associatedProductIds = array(19,20); 
            foreach ($attributes as $attributeId) {
                $data = array('attribute_id' => $attributeId, 'product_id' => $productId, 'position' => $position);
                $position++;
                $attributeModel->setData($data)->save();
            }
            $product->setTypeId("configurable"); 
            $product->setAffectConfigurableProductAttributes(4);
            $this->configurable->setUsedProductAttributeIds($attributes, $product);
            $product->setNewVariationsAttributeSetId(4); 
            $product->setAssociatedProductIds($associatedProductIds);
            $product->setCanSaveConfigurableAttributes(true);
            $product->save();
    
        } catch(\Exception $e) {
            return $e->getMessage();
        }

    }
}

