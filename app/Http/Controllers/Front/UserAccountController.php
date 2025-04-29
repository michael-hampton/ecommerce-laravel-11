<?php

namespace App\Http\Controllers\Front;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCommentRequest;
use App\Http\Requests\PostReplyRequest;
use App\Http\Requests\StoreCustomerAddressRequest;
use App\Models\Comment;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Post;
use App\Models\SellerBalance;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Cart\Facade\Cart;
use App\Services\Interfaces\IMessageService;
use App\Services\Interfaces\IOrderService;
use function auth;

class UserAccountController extends Controller
{
    public function __construct(
        private IOrderRepository   $orderRepository,
        private IOrderService      $orderService,
        private IAddressRepository $addressRepository,
        private IMessageService   $messageService,
    )
    {

    }

    public function index() {
        return view('front.user.index');
    }

    public function orders()
    {
        $orders = $this->orderRepository->getPaginated(10, 'id', 'desc', ['customer_id' => auth()->id()]);

        return view('front.user.orders', compact('orders'));
    }

    public function orderDetails(int $orderId)
    {
        $order = $this->orderRepository->getById($orderId);

        return view('front.user.order-details', compact('order'));
    }

    public function cancelOrder(int $orderId)
    {
        $this->orderService->updateOrder(['status' => 'cancelled'], $orderId);
        return back()->with('success', 'Order cancelled');
    }

    public function approveOrder(int $orderId)
    {
        $this->orderService->approveOrder($orderId);
        return back()->with('success', 'Order cancelled');
    }

    public function approveOrderItem(int $orderItemId)
    {
        $this->orderService->approveOrderItem($orderItemId);
        return back()->with('success', 'Order cancelled');
    }

    public function reportOrder(int $orderItemId)
    {
        $orderItem = OrderItem::whereId($orderItemId)->first();
        $posts = Post::where('user_id', auth()->id())->get();

        return view('front.user.account-ask-a-question', compact('posts', 'orderItemId', 'orderItem'));
    }

    public function address()
    {
        $addresses = $this->addressRepository->getCollectionByColumn(auth()->id(), 'customer_id');

        return view('front.user.account-address', compact('addresses'));
    }

    public function addAddress()
    {
        return view('user.account-address-add');
    }

    public function storeAddress(StoreCustomerAddressRequest $request)
    {
       $this->addressRepository->create([
           'customer_id' => auth()->id(),
           'name' => $request->get('name'),
           'address1' => $request->get('address1'),
           'address2' => $request->get('address2'),
           'city' => $request->get('city'),
           'zip' => $request->get('zip'),
           'phone' => $request->get('phone'),
           'state' => $request->get('state'),
           'is_default' => !empty($request->get('isdefault')) ? 1 : 0,
           'country' => $request->get('country') ?? 'United Kingdom',
       ]);

       return back()->with('success', 'Address added');
    }

    public function editAddress(int $addressId)
    {
        $address = $this->addressRepository->getById($addressId);
        return view('front.user.account-address-edit', compact('address'));
    }

     public function updateAddress(StoreCustomerAddressRequest $request, int $addressId)
     {
         $this->addressRepository->update($addressId, [
             'customer_id' => auth()->id(),
             'name' => $request->get('name'),
             'address1' => $request->get('address1'),
             'address2' => $request->get('address2'),
             'city' => $request->get('city'),
             'zip' => $request->get('zip'),
             'phone' => $request->get('phone'),
             'state' => $request->get('state'),
             'is_default' => !empty($request->get('isdefault')) ? 1 : 0,
             'country' => $request->get('country') ?? 'United Kingdom',
         ]);

         return back()->with('success', 'Address updated');
     }

    public function wishlist()
    {
        $wishlistItems = Cart::instance('wishlist')->getStoredItems();
        return view('front.user.account-wishlist', compact('wishlistItems'));
    }

    public function reviews()
    {
        $reviews = auth()->user()->reviews()->get();
        return view('front.user.account-review', compact('reviews'));
    }

    public function askQuestion()
    {
        $posts = Post::where('user_id', auth()->id())->get();

        return view('front.user.account-ask-a-question', compact('posts'));
    }

    public function createQuestion(PostCommentRequest $request)
    {
        $result = $this->messageService->createMessage($request->all());

        return back()->with('success', 'Question posted');
    }

    public function askQuestionDetails(int $id)
    {
        $post = Post::whereId($id)->first();
        return view('front.user.account-ask-a-question-details', compact('post'));
    }

    public function postReply(PostReplyRequest $request)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $request->input('postId'),
            'message' => $request->input('message')
        ]);

        return back()->with('success', 'Post reply successfully');
    }
}
