<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostReplyRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Profile;
use App\Repositories\Interfaces\IOrderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct(private readonly IOrderRepository $orderRepository) {}

    public function index()
    {
        $dashboardData = DB::select("Select sum((price + shipping_price)) AS TotalAmount,
                            sum(if(orders.status='ordered', (price + shipping_price), 0)) as TotalOrderedAmount,
                            sum(if(orders.status='delivered', (price + shipping_price), 0)) as TotalDeliveredAmount,
                            sum(if(orders.status='cancelled', (price + shipping_price), 0)) as TotalCancelledAmount,
                              sum(if(orders.status='ordered', 1, 0)) as TotalOrdered,
                            sum(if(orders.status='delivered', 1, 0)) as TotalDelivered,
                            sum(if(orders.status='cancelled', 1, 0)) as TotalCancelled,
                            COUNT(*) AS Total
                            FROM orders
                            INNER JOIN order_items ON order_items.order_id = orders.id
                            WHERE seller_id = ".Auth::user()->id.'
                            ');

        $data = DB::select("SELECT DATE_FORMAT(order_items.created_at, '%m') AS Month, SUM(price) AS total,
                                sum(if(orders.status='ordered', price, 0)) as TotalOrderedAmount,
                            sum(if(orders.status='delivered', price, 0)) as TotalDeliveredAmount,
                            sum(if(orders.status='cancelled', price, 0)) as TotalCancelledAmount
                                FROM order_items
                                INNER JOIN orders ON order_items.order_id = orders.id
                                WHERE YEAR(order_items.created_at) = ".date('Y')."
                                GROUP BY DATE_FORMAT(order_items.created_at, '%m')");

        $orders = $this->orderRepository->getPaginated(10, 'created_at', 'desc', ['seller_id' => \auth()->id()]);

        $months = [];

        foreach ($data as $item) {
            $months[$item->Month] = $item->total;
        }

        return view('admin.index', ['dashboardData' => $dashboardData, 'orders' => $orders, 'months' => $months]);
    }

    public function askQuestion()
    {
        $posts = Post::where('seller_id', \auth()->id())->get();

        return view('admin.ask-a-question', ['posts' => $posts]);
    }

    public function askQuestionDetails(int $id)
    {
        $post = Post::whereId($id)->first();

        return view('admin.ask-a-question-details', ['post' => $post]);
    }

    public function postReply(PostReplyRequest $postReplyRequest)
    {
        Comment::create([
            'user_id' => \auth()->id(),
            'post_id' => $postReplyRequest->input('postId'),
            'message' => $postReplyRequest->input('message'),
        ]);

        return back()->with('success', 'Post reply successfully');
    }

    public function profile()
    {
        $profile = Profile::whereId(\auth()->id())->first();

        return view('admin.profile.profile', ['profile' => $profile]);
    }

    public function updateProfile(Request $request)
    {
        $profile = Profile::whereId(\auth()->id())->first();
        $filename = $profile->profile_picture;
        if ($request->hasFile('profile_pic')) {
            $filename = $request->file('profile_pic')->getClientOriginalName();
            $request->file('profile_pic')->storeAs('sellers', $filename, 'public');
        }

        Profile::updateOrCreate(
            ['user_id' => \auth()->id()],
            [
                'profile_picture' => $filename,
                'biography' => $request->input('bio') ?? '',
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'zip' => $request->input('zip'),
                'address1' => $request->input('address1'),
                'address2' => $request->input('address2'),
                'phone' => $request->input('phone'),
                'username' => $request->input('username'),
                'name' => $request->input('name'),
                'website' => $request->input('website') ?? '',
                'country' => $request->input('country') ?? '',
                'email' => $request->input('email') ?? '',
            ]
        );

        return back()->with('success', 'Profile updated successfully');
    }
}
