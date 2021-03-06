<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Medine\ERP\ClientCategories\Domain\Contracts\ClientCategoryRepository;
use Medine\ERP\ClientCategories\Infrastructure\Persistence\MysqlClientCategoryRepository;
use Medine\ERP\ClientTypes\Domain\Contracts\ClientTypeRepository;
use Medine\ERP\ClientTypes\Infrastructure\Persistence\MysqlClientTypesRepository;
use Medine\ERP\ItemCategories\Domain\Entity\ItemCategoryRepository;
use Medine\ERP\ItemCategories\Infrastructure\Persistence\MySqlItemCategoryRepository;
use Medine\ERP\Locations\Domain\LocationRepository;
use Medine\ERP\Locations\Infrastructure\MySqlLocationRepository;
use Medine\ERP\Items\Domain\Contracts\ItemRepository;
use Medine\ERP\Items\Infrastructure\MySqlItemRepository;
use Medine\ERP\Clients\Domain\Contracts\ClientRepository;
use Medine\ERP\Clients\Infrastructure\Repository\MySqlClientRepository;
use Medine\ERP\PurchaseInvoices\Domain\PurchaseInvoiceRepository;
use Medine\ERP\PurchaseInvoices\Infrastructure\Persistence\MySqlPurchaseInvoiceRepository;
use Medine\ERP\Roles\Infrastructure\MySqlRolRepository;
use Medine\ERP\Roles\Domain\RolRepository;
use Medine\ERP\Shared\Domain\Bus\Event\EventBus;
use Medine\ERP\Shared\Domain\Bus\Event\SendEmailNotificationOnPasswordResetCreated;
use Medine\ERP\Shared\Domain\CatalogRepository;
use Medine\ERP\Shared\Infrastructure\Bus\Event\InMemory\InMemorySymfonyEventBus;
use Medine\ERP\Shared\Infrastructure\MySqlCatalogRepository;
use Medine\ERP\Users\Domain\PasswordResetRepository;
use Medine\ERP\Users\Domain\UserRepository;
use Medine\ERP\Users\Infrastructure\MySqlPasswordResetRepository;
use Medine\ERP\Users\Infrastructure\MySqlUserRepository;
use Medine\ERP\Company\Domain\CompanyRepository;
use Medine\ERP\Company\Infrastructure\MySqlCompanyRepository;
use Medine\ERP\Company\Domain\CompanyHasUserRepository;
use Medine\ERP\Company\Infrastructure\MySqlCompanyHasUserRepository;
use function Lambdish\Phunctional\each;

class AppServiceProvider extends ServiceProvider
{
    private const TAGGED_SUBSCRIBERS = 'subscribers';

    private $wiringObjects = [
        UserRepository::class => MySqlUserRepository::class,
        CompanyRepository::class => MySqlCompanyRepository::class,
        CompanyHasUserRepository::class => MySqlCompanyHasUserRepository::class,
        RolRepository::class => MySqlRolRepository::class,
        PasswordResetRepository::class => MySqlPasswordResetRepository::class,
        PurchaseInvoiceRepository::class => MySqlPurchaseInvoiceRepository::class,
        LocationRepository::class => MySqlLocationRepository::class,
        ItemRepository::class => MySqlItemRepository::class,
        ClientRepository::class => MySqlClientRepository::class,
        ClientCategoryRepository::class => MysqlClientCategoryRepository::class,
        ClientTypeRepository::class => MysqlClientTypesRepository::class,
        CatalogRepository::class => MySqlCatalogRepository::class,
        ItemCategoryRepository::class => MySqlItemCategoryRepository::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        each(function ($concrete, $abstract) {
            $this->app->bind(
                $abstract,
                $concrete
            );
        }, $this->wiringObjects);

        $this->app->bind(EventBus::class, function () {
            $subscribers = [];
            each(function ($row) use (&$subscribers) {
                $subscribers[] = $row;
            }, $this->app->tagged(self::TAGGED_SUBSCRIBERS));
            return new InMemorySymfonyEventBus($subscribers);
        });

        $this->app->tag(
            [
                SendEmailNotificationOnPasswordResetCreated::class
            ],
            [self::TAGGED_SUBSCRIBERS]
        );
    }
}
