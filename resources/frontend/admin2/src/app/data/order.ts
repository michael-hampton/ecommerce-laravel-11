import {User} from './user';

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
  tracking_number: number,
  courier_name: string
  customer?: User
  order_date: string
  number_of_items: number
  delivered_date: string
}
