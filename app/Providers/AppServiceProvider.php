<?php

namespace App\Providers;

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
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISellerRepository;
use App\Repositories\Interfaces\ISlideRepository;
use App\Repositories\Interfaces\ITransactionRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\MessageRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SellerRepository;
use App\Repositories\SlideRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\AddressService;
use App\Services\AttributeService;
use App\Services\AttributeValueService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CouponService;
use App\Services\DeliveryMethodService;
use App\Services\Interfaces\IAddressService;
use App\Services\Interfaces\IAttributeService;
use App\Services\Interfaces\IAttributeValueService;
use App\Services\Interfaces\IBrandService;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\ICouponService;
use App\Services\Interfaces\IDeliveryMethodService;
use App\Services\Interfaces\IMessageService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\ISellerService;
use App\Services\Interfaces\ISlideService;
use App\Services\Interfaces\IUserService;
use App\Services\MessageService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SellerService;
use App\Services\SlideService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    private $repositories = [
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
    ];

    /**
     * @var string[]
     */
    private $services = [
        IDeliveryMethodService::class => DeliveryMethodService::class,
        IProductService::class => ProductService::class,
        IOrderService::class => OrderService::class,
        ICouponService::class => CouponService::class,
        IBrandService::class => BrandService::class,
        ICategoryService::class => CategoryService::class,
        IAddressService::class => AddressService::class,
        IUserService::class => UserService::class,
        ISlideService::class => SlideService::class,
        IAttributeService::class => AttributeService::class,
        IAttributeValueService::class => AttributeValueService::class,
        ISellerService::class => SellerService::class,
        IMessageService::class => MessageService::class,
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $repository) {
            $this->app->bind($interface, $repository);
        }

        foreach ($this->services as $interface => $service) {
            $this->app->bind($interface, $service);
        }

        $this->app->singleton('Image', function ($app) {
            return new Image();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
