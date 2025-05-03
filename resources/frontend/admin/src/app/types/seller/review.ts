import { Product } from "../products/product";
import { User } from "../users/user";

export type ReviewCollection = {
    seller_reviews: Review[]
    product_reviews: Review[]
}

export type Review = {
    id: number;
    user: User
    comment: string
    rating: number
    product?: Product
    type: string
    created_at: string
    replies: Review
}