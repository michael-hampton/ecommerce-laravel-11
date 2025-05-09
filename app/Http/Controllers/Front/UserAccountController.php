<?php



namespace App\Http\Controllers\Front;

use App\Actions\Address\CreateAddress;
use App\Actions\Address\UpdateAddress;
use App\Actions\Message\CreateMessage;
use App\Actions\Order\ApproveOrder;
use App\Actions\Order\UpdateOrder;
use App\Events\IssueReported;
use App\Http\Controllers\Controller;
use App\Http\Requests\ApproveOrderRequest;
use App\Http\Requests\PostCommentRequest;
use App\Http\Requests\PostReplyRequest;
use App\Http\Requests\ReportIssueRequest;
use App\Http\Requests\StoreCustomerAddressRequest;
use App\Models\Comment;
use App\Models\Country;
use App\Models\OrderItem;
use App\Models\Post;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Services\Cart\Facade\Cart;

use Illuminate\Support\Facades\View;
use function auth;

class UserAccountController extends Controller
{
    public function __construct(
        private readonly IOrderRepository $orderRepository,
        private readonly IAddressRepository $addressRepository,
    ) {}

    public function index()
    {
        return view('front.user.index');
    }

    public function orders()
    {
        $orders = $this->orderRepository->getPaginated(10, 'id', 'desc', ['customer_id' => auth()->id()]);

        return view('front.user.orders', ['orders' => $orders]);
    }

    public function orderDetails(int $orderId)
    {
        $order = $this->orderRepository->getById($orderId);

        return view('front.user.order-details', ['order' => $order]);
    }

    public function cancelOrder(int $orderId, UpdateOrder $updateOrder)
    {
        $updateOrder->handle(['status' => 'cancelled'], $orderId);

        return back()->with('success', 'Order cancelled');
    }

    public function approveOrder(ApproveOrderRequest $approveOrderRequest, int $orderId, ApproveOrder $approveOrder)
    {
        $result = $approveOrder->handle($orderId, $approveOrderRequest->array('values'));

        return response()->json($result);
    }

    public function reportOrder(int $orderItemId, ReportIssueRequest $reportIssueRequest, CreateMessage $createMessage)
    {

        $reason = trim($reportIssueRequest->string('reason'));
        $orderItem = OrderItem::whereId($orderItemId);
        $title = $reason === 'returnRefund' ? 'Refund Requested from buyer. Items should be returned' : 'Refund Requested from buyer. They do not wish to return the items';

        if ($reason === 'returnRefund' || $reason === 'refundNoReturn') {
            $orderItem->update(['status' => 'refund_requested']);
        }

        $orderItem = $orderItem->first();

        $result = $createMessage->handle([
            'title' => $title,
            'images' => $reportIssueRequest->file('images'),
            'comment' => $reportIssueRequest->string('message'),
            'sellerId' => $orderItem->seller_id,
            'order_item_id' => $orderItem->id,
            'user_id' => auth()->user()->id,
        ]);

        event(new IssueReported(auth()->user()->email, [
            'item' => $orderItem,
            'currency' => config('shop.currency'),
            'message' => $reportIssueRequest->string('message'),
            'resolution' => $title,
            'customer' => auth()->user()->name,
        ]));

        return response()->json($result);
    }

    public function address()
    {
        $addresses = $this->addressRepository->getCollectionByColumn(auth()->id(), 'customer_id');
        $defaultAddress = $addresses->where('is_default', 1)->first();
        $otherAddresses = $addresses->where('is_default', 0)->all();
        $countries = Country::orderBy('name', 'asc')->get();

        return view('front.user.account-address', [
            'addresses' => $addresses, 
            'defaultAddress' => $defaultAddress, 
            'otherAddresses' => $otherAddresses,
            'countries' => $countries
        ]);
    }

    public function addAddress()
    {
        return view('user.account-address-add');
    }

    public function storeAddress(StoreCustomerAddressRequest $storeCustomerAddressRequest, CreateAddress $createAddress)
    {
        $result = $createAddress->handle(array_merge($storeCustomerAddressRequest->all(), ['customer_id' => auth()->id()]));
        $countries = Country::orderBy('name', 'asc')->get();
        $view = View::make('front.user.partials.address-list', ['address' => $result, 'countries' => $countries])->render();

        return response()->json(['result' => $result, 'view' => $view]);
    }

    public function editAddress(int $addressId)
    {
        $address = $this->addressRepository->getById($addressId);

        return view('front.user.account-address-edit', ['address' => $address]);
    }

    public function updateAddress(StoreCustomerAddressRequest $storeCustomerAddressRequest, int $addressId, UpdateAddress $updateAddress)
    {
       $result = $updateAddress->handle($storeCustomerAddressRequest->all(), $addressId);

       return response()->json($result);
    }

    public function wishlist()
    {
        $wishlistItems = Cart::instance('wishlist')->getStoredItems();

        return view('front.user.account-wishlist', ['wishlistItems' => $wishlistItems, 'currency' => config('shop.currency')]);
    }

    public function reviews()
    {
        $reviews = auth()->user()->reviews()->get();

        return view('front.user.account-review', ['reviews' => $reviews]);
    }

    public function askQuestion()
    {
        $posts = Post::where('user_id', auth()->id())->get();

        return view('front.user.account-ask-a-question', ['posts' => $posts]);
    }

    public function createQuestion(PostCommentRequest $postCommentRequest, CreateMessage $createMessage)
    {
        $createMessage->handle($postCommentRequest->all());

        return back()->with('success', 'Question posted');
    }

    public function askQuestionDetails(int $id)
    {
        $post = Post::whereId($id)->first();

        return view('front.user.account-ask-a-question-details', ['post' => $post]);
    }

    public function postReply(PostReplyRequest $postReplyRequest)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $postReplyRequest->input('postId'),
            'message' => $postReplyRequest->input('message'),
        ]);

        return back()->with('success', 'Post reply successfully');
    }
}
