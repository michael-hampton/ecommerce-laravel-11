export type SaveOrderLine = {
  id: number;
  lineId: number
  status: string
  tracking_number: string
  courier_id: number
}

export type SaveOrder = {
  orderId: number
  status: string
  tracking_number: string
  courier_id: number
}
