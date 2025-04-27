export type BalanceCollection = {
  balances: Balance[]
  current: Balance
}

export type Balance = {
  seller_id: number;
  balance: string
}
