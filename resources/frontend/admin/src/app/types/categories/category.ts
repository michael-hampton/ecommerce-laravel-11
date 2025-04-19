export type Category = {
  id: number;
  name: string;
  slug: string;
  image: string;
  parent_id: number;
  products?: number
  subcategories?: Category[]
}
