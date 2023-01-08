<?php
namespace Interview\Task\Api;

interface ProductCreationInterface
{
    /**
     * Returns product created success message to user
     *
     * @api
     * @return mixed 
     */
    public function simpleProduct();

    /**
     * Returns product created success message to user
     *
     * @api
     * @return mixed 
     */
    public function configProduct();
}