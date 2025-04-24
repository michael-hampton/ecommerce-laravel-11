export type SaveOrderLine = {
  id: number;
  lineId: number
  status: string
  tracking_number: string
  courier_name: string
}

export type SaveOrder = {
  orderId: number
  status: string
  tracking_number: string
  courier_name: string
}
