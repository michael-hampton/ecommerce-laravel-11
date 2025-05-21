import { User } from '../users/user';
import { Address } from './address';
import { Customer } from './customer';
import { OrderItem } from './orderItem';

export type Order = {
  id: number,
  customer_id: number,
  subtotal: number,
  shipping: number,
  discount: number,
  tax: number,
  status: string,
  is_shipping_different: boolean,
  note: string,
  delivery_date: string,
  cancelled_date: string,
  address_id: number,
  review_status: string,
  total: number,
  commission: number,
  tracking_number: string,
  courier_id: number
  customer?: Customer
  order_date: string
  number_of_items: number
  delivered_date: string
  address: Address
  orderItems: OrderItem[]
}
