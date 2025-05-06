<?php



namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactUsRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\Contact;
use App\Models\FaqCategory;
use App\Models\FaqQuestion;
use App\Models\User;
use App\Repositories\Interfaces\IBrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISlideRepository;
use App\Services\Cart\Facade\Cart;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct(
        private ICategoryRepository $categoryRepository,
        private IProductRepository $productRepository,
        private ISlideRepository $slideRepository,
        private IBrandRepository $brandRepository
    ) {}

    public function index()
    {
        $categories = $this->categoryRepository->getAll(null, 'name', 'asc', ['is_featured' => true]);
        $products = $this->productRepository->getHotDeals();
        $featuredProducts = $this->productRepository->getFeaturedProducts();
        $currency = config('shop.currency');
        $slides = $this->slideRepository->getAll(null, 'created_at', 'desc');

        if (Auth::check()) {
            Cart::instance('cart')->restore(Auth::user()->email);
            Cart::instance('wishlist')->restore(Auth::user()->email);

        }

        return view('front/index', compact('categories', 'products', 'currency', 'featuredProducts', 'slides'));
    }

    public function changePassword()
    {
        return view('change-password');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        // Match The Old Password
        if (! Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with('error', "Old Password Doesn't match!");
        }

        // Update the new Password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('status', 'Password changed successfully!');
    }

    public function about()
    {
        return view('front.about');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function help()
    {
        $categories = FaqCategory::all();
        // $questions = FaqQuestion::all()->groupBy('category_id');

        return view('front.help', compact('categories'));
    }

    public function helpTopic(string $slug)
    {
        $questions = FaqQuestion::with('category')
            ->whereHas('category', function (Builder $query) use ($slug) {
                $query->where('slug', '=', $slug);
            })
            ->get();

        return view('front.help-topic', compact('questions'));
    }

    public function terms()
    {
        return view('front.terms');
    }

    /**
     * Write code on Method
     *
     *
     *
     * @return response()
     */
    public function store(ContactUsRequest $request)
    {
        Contact::create($request->all());

        return redirect()->back()->with(['success' => 'Thank you for contact us. we will contact you shortly.']);

    }
}
