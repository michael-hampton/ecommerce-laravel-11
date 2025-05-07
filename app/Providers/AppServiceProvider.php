<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\User;
use App\Repositories\AddressRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\AttributeValueRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CountryRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CourierRepository;
use App\Repositories\DeliveryMethodRepository;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IAttributeRepository;
use App\Repositories\Interfaces\IAttributeValueRepository;
use App\Repositories\Interfaces\IBrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\ICountryRepository;
use App\Repositories\Interfaces\ICouponRepository;
use App\Repositories\Interfaces\ICourierRepository;
use App\Repositories\Interfaces\IDeliveryMethodRepository;
use App\Repositories\Interfaces\IMessageRepository;
use App\Repositories\Interfaces\IOrderItemRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\ISlideRepository;
use App\Repositories\Interfaces\ITransactionRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\Interfaces\Support\IArticleRepository;
use App\Repositories\Interfaces\Support\ICategoryRepository as ISupportCategoryRepository;
use App\Repositories\Interfaces\Support\IQuestionRepository;
use App\Repositories\MessageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SellerRepository;
use App\Repositories\SlideRepository;
use App\Repositories\Support\ArticleRepository;
use App\Repositories\Support\CategoryRepository as SupportCategoryRepository;
use App\Repositories\Support\QuestionRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    private array $repositories = [
        ICourierRepository::class, CourierRepository::class,
        IDeliveryMethodRepository::class, DeliveryMethodRepository::class,
        ISellerRepository::class => SellerRepository::class,
        IProductRepository::class => ProductRepository::class,
        IOrderRepository::class => OrderRepository::class,
        ICouponRepository::class => CouponRepository::class,
        IBrandRepository::class => BrandRepository::class,
        ICategoryRepository::class => CategoryRepository::class,
        IAddressRepository::class => AddressRepository::class,
        IUserRepository::class => UserRepository::class,
        ISlideRepository::class => SlideRepository::class,
        IAttributeRepository::class => AttributeRepository::class,
        IAttributeValueRepository::class => AttributeValueRepository::class,
        IMessageRepository::class => MessageRepository::class,
        ICountryRepository::class => CountryRepository::class,
        ITransactionRepository::class => TransactionRepository::class,
        IArticleRepository::class => ArticleRepository::class,
        ISupportCategoryRepository::class => SupportCategoryRepository::class,
        IQuestionRepository::class => QuestionRepository::class,
        IOrderItemRepository::class => OrderItemRepository::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->repositories as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }

        $this->app->singleton('Image', fn($app): \App\Providers\Image => new Image);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        VerifyEmail::toMailUsing(fn(object $notifiable, string $url) => (new MailMessage)
            ->subject('Verify Email Address')
            ->line('Click the button below to verify your email address.')
            ->action('Verify Email Address', $url));

        ResetPassword::createUrlUsing(fn(User $user, string $token) => url(route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset(),
        ], false)));

        ResetPassword::toMailUsing(function (User $user, string $token) {
            $url = url(route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false));

            return (new MailMessage)
                ->subject(config('app.name').': '.__('Reset Password Request'))
                ->greeting(__('Hello!'))
                ->line(__('You are receiving this email because we received a password reset request for your account.'))
                ->action(__('Reset Password'), $url)
                ->line(__('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(__('If you did not request a password reset, no further action is required.'))
                ->salutation(__('Regards,')."\n".config('app.name').' Team');
        });
    }
}
