<?php

namespace App\Repositories\Order;

interface OrderRepository {
	public function getAll();

	public function getById( $id );

	public function create( array $attributes );

	public function createFrontendOrder( array $attributes );

	public function update( $id, array $attributes );

	public function updateFrontendOrder( $id, array $attributes );

	public function delete( $id );

	public function getUserOrders($id);

	public function getOrdersJson(array $attributes );
}