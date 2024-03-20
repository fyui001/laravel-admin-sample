<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Auth\AdminUser;
use Domain\AdminUser\AdminUser as AdminUserDomain;
use Domain\AdminUser\AdminUserId;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Infra\EloquentRepository\AdminUserRepository;
use Tests\TestCase;

class FeatureTestCase extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    private AdminUserRepository $adminUserRepository;
    protected AdminUserDomain $adminUser;


    public function setUp(): void
    {
        parent::setUp();

        $this->adminUserRepository = $this->app->make(AdminUserRepository::class);

        $this->adminUser = $this->adminUserRepository->getByUserId(
            new AdminUserId('takada_yuki'),
        );
        Storage::fake();
    }

    public function adminLogin(): void
    {
        $admin = new AdminUser(
            $this->adminUserRepository->getByUserId(
                new AdminUserId('takada_yuki'),
            )
        );

        $this->be($admin, 'web');
    }
}
