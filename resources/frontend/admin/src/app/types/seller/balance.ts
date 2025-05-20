export type BalanceCollection = {
  balances: Balance[]
  current: Balance
  pending_owing: string
  pending_owed: string
}

export type Balance = {
  seller_id: number;
  balance: string
}
