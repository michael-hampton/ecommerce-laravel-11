<?php

namespace App\Providers;

use App\Repositories\AddressRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CouponRepository;
use App\Repositories\Interfaces\IAddressRepository;
use App\Repositories\Interfaces\IBrandRepository;
use App\Repositories\Interfaces\ICategoryRepository;
use App\Repositories\Interfaces\ICouponRepository;
use App\Repositories\Interfaces\IOrderRepository;
use App\Repositories\Interfaces\IProductRepository;
use App\Repositories\Interfaces\ISlideRepository;
use App\Repositories\Interfaces\IUserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SlideRepository;
use App\Repositories\UserRepository;
use App\Services\AddressService;
use App\Services\BrandService;
use App\Services\CategoryService;
use App\Services\CouponService;
use App\Services\Interfaces\IAddressService;
use App\Services\Interfaces\IBrandService;
use App\Services\Interfaces\ICategoryService;
use App\Services\Interfaces\ICouponService;
use App\Services\Interfaces\IOrderService;
use App\Services\Interfaces\IProductService;
use App\Services\Interfaces\ISlideService;
use App\Services\Interfaces\IUserService;
use App\Services\OrderService;
use App\Services\ProductService;
use App\Services\SlideService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var string[]
     */
    private $repositories = [
        IProductRepository::class => ProductRepository::class,
        IOrderRepository::class => OrderRepository::class,
        ICouponRepository::class => CouponRepository::class,
        IBrandRepository::class => BrandRepository::class,
        ICategoryRepository::class => CategoryRepository::class,
        IAddressRepository::class => AddressRepository::class,
        IUserRepository::class => UserRepository::class,
        ISlideRepository::class => SlideRepository::class,
    ];

    /**
     * @var string[]
     */
    private $services = [
        IProductService::class => ProductService::class,
        IOrderService::class => OrderService::class,
        ICouponService::class => CouponService::class,
        IBrandService::class => BrandService::class,
        ICategoryService::class => CategoryService::class,
        IAddressService::class => AddressService::class,
        IUserService::class => UserService::class,
        ISlideService::class => SlideService::class,
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
