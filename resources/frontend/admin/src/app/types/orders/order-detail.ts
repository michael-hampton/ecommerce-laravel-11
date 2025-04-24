import {Customer} from './customer';
import {Transaction} from './transaction';
import {OrderLog} from './orderLog';
import {OrderItem} from './orderItem';
import {Address} from './address';
import {Order} from './order';
import {Total} from './total';

export type OrderDetail = Order & {
  customer: Customer
  address: Address
  transactions: Transaction[]
  orderLogs: OrderLog[]
  orderItems: OrderItem[]
  totals: Total
}

