<?php

class OrderModel
{
    private $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getOrder($orderID)
    {
        return $order = $this->repository->load($orderID);
    }

}

interface OrderRepository
{
    public function load($orderID);
}

class MySQLOrderRepository implements OrderRepository
{
    public function load($orderID) : string
    {
        return 'Order from MySQL reposiroty with id ' . $orderID . PHP_EOL;
    }

}

class OneCOrderRepository implements OrderRepository
{
    public function load($orderID) : string
    {
        return 'Order from 1c reposiroty with id ' . $orderID . PHP_EOL;
    }

}

$orderModel = new OrderModel(new MySQLOrderRepository());

$orderId = 3;

echo $orderModel->getOrder($orderId);
