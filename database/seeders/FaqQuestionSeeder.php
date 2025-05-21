<?php

namespace Database\Seeders;

use App\Models\FaqQuestion;
use Illuminate\Database\Seeder;

class FaqQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            ['question' => 'How do I create an account', 'answer' => 'Click on the "Sign Up" button at the top of the homepage and follow the instructions to register as a buyer.', 'category_id' => 3],
            ['question' => 'How do I place an order', 'answer' => 'Browse products, add them to your cart, and proceed to checkout. Choose your preferred payment method and complete the transaction.', 'category_id' => 3],
            ['question' => 'Can I buy from multiple vendors in one order', 'answer' => 'Yes, but each vendor’s products will be shipped separately and may have different delivery times and charges.', 'category_id' => 3],
            ['question' => 'What payment methods are accepted', 'answer' => 'We accept credit/debit cards, PayPal, and other secure payment options listed at checkout.', 'category_id' => 3],
            ['question' => 'How can I track my order', 'answer' => 'Once a vendor ships your order, you will receive tracking information via email or in your account dashboard.', 'category_id' => 3],
            ['question' => 'What is the return policy', 'answer' => 'Return policies vary by vendor. Check the return policy on the vendor’s product page or contact them directly.', 'category_id' => 3],
            ['question' => 'What if I receive a damaged or incorrect item', 'answer' => 'Contact the vendor through your account. If the issue isn’t resolved, you can escalate it through our support team.', 'category_id' => 3],
            ['question' => 'How do I become a vendor', 'answer' => 'Click “Sell on [Marketplace Name]” and complete the registration process. Your store will be reviewed and approved within [X] business days.', 'category_id' => 2],
            ['question' => 'What can I sell on the platform', 'answer' => 'You can sell most legal physical goods and services, as long as they comply with our product guidelines and prohibited items list.', 'category_id' => 2],
            ['question' => 'Are there any fees to sell', 'answer' => 'We charge a commission per sale and may have listing or subscription fees. Full details are available in your vendor dashboard.', 'category_id' => 2],
            ['question' => 'How do I receive payments', 'answer' => 'Payments are processed via [Payment Gateway Name] and transferred to your linked account after order confirmation.', 'category_id' => 2],
            ['question' => 'How do I manage orders and inventory', 'answer' => 'You can manage your products, stock, and orders via the vendor dashboard.', 'category_id' => 2],
            ['question' => 'Can I customize my store page', 'answer' => 'Yes, you can add a logo, banners, business description, and contact info to personalize your vendor store.', 'category_id' => 2],
            ['question' => 'Is ShopPinoy secure', 'answer' => 'Yes, we use industry-standard encryption and secure payment processing to protect your information.', 'category_id' => 1],
            ['question' => 'Who do I contact for support', 'answer' => 'You can reach us at [Support Email] or through the contact form on our website.', 'category_id' => 1],
            ['question' => 'Can I use the platform from any country', 'answer' => 'Currently, we support [List of Countries/Regions]. More locations will be added in the future.', 'category_id' => 1],
            ['question' => 'Does ShopPinoy handle shipping', 'answer' => 'Shipping is managed by individual vendors. Delivery times and couriers may vary.', 'category_id' => 1],
            ['question' => 'How are disputes handled', 'answer' => 'We encourage buyers and sellers to resolve issues directly using the contact seller page. If unresolved, our support team can mediate', 'category_id' => 1],
            ['question' => 'Do you store credit card details', 'answer' => 'At our multi-vendor marketplace, your security is a top priority. That’s why we do not store any payment-related information—including your credit card or bank account details—on our servers. All payments are securely processed through Stripe, a trusted and industry-leading third-party payment provider. Stripe handles all transactions and sensitive financial data using advanced encryption and security protocols to keep your information safe. By using Stripe, we ensure that your payment experience is fast, secure, and fully compliant with the highest standards in online payments.', 'category_id' => 3],
            ['question' => 'What is buyer protection insurance', 'answer' => 'Buyer Protection Insurance Your peace of mind is our priority. That’s why every purchase made on our marketplace is automatically covered by Buyer Protection Insurance—at no extra cost. With Buyer Protection, you\'re covered if: Your order doesn’t arrive Your item arrives damaged The item is significantly not as described How it works: No Payment Until You’re Satisfied: We don’t capture payment until you confirm that you’re happy with your order by clicking the “I am happy with my order” button. If you don’t confirm, we’ll wait 5 days after the delivery date before automatically finalizing the order—unless you report an issue. Reporting an Issue: If something’s wrong with your order, go to the Order Details page and click the “I have an issue” button before the 5-day window ends. This will pause the transaction and open a case for review. Communicate with the Seller: You can use our Messages feature to contact the seller directly. Share details, ask questions, or upload images to help resolve any problems quickly and smoothly. All transactions are securely processed through Stripe, and we never store your sensitive payment information.', 'category_id' => 3],
            ['question' => 'How does the seller balance work', 'answer' => 'The Seller Balance is where vendors can track the funds they’ve earned from completed orders on our marketplace. To ensure a secure and trustworthy experience for both buyers and sellers, payments are only captured after the buyer confirms they are satisfied with their order.', 'category_id' => 2],

        ];

        foreach ($questions as $question) {
            FaqQuestion::create($question);
        }
    }
}
