<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Domain\AdminUser\AdminUserId;
use Domain\AdminUser\AdminUserRole;
use Domain\AdminUser\AdminUserStatus;
use Domain\Exception\NotFoundException;
use Infra\EloquentRepository\AdminUserRepository;
use Tests\Feature\FeatureTestCase;

class AdminUserControllerTest extends FeatureTestCase
{
    private AdminUserRepository $adminUserRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->adminLogin();
        $this->adminUserRepository = $this->app->make(AdminUserRepository::class);
    }

    public function testIndex()
    {
        $this->get(route('admin.admin_users.index'))->assertOk();
    }

    public function testCreate()
    {
        $this->get(route('admin.admin_users.create'))->assertOk();
    }

    public function testStore()
    {
        $params = [
            'user_id' => 'test_takada_yuki',
            'password' => 'hogehoge',
            'password_confirm' => 'hogehoge',
            'name' => '高田憂希',
            'role' => AdminUserRole::SYSTEM->getValue()->getRawValue(),
            'status' => AdminUserStatus::VALID->getValue()->getRawValue(),
        ];

        $this->post(route('admin.admin_users.store'), $params)
            ->assertRedirect(route('admin.admin_users.index'))
            ->assertSessionHas('success');

        $response = $this->adminUserRepository->getByUserId(new AdminUserId('test_takada_yuki'));

        $this->assertTrue(
            $response->getUserId()->isEqual($params['user_id'])
        );
    }

    public function testEdit()
    {
        $this->get(route('admin.admin_users.edit', $this->adminUser->getId()))->assertOk();
    }

    public function testUpdate()
    {
        $response = $this->adminUserRepository->getByUserId(new AdminUserId('takada_yuki'));

        $params = [
            'user_id' => 'takada_yuki_test',
            'password' => 'test_takada_yuki_pass',
            'password_confirm' => 'test_takada_yuki_pass',
            'name' => '高田憂希',
            'role' => AdminUserRole::SYSTEM->getValue()->getRawValue(),
            'status' => AdminUserStatus::VALID->getValue()->getRawValue(),
        ];

        $this->put(route('admin.admin_users.update', $response->getId()), $params)
            ->assertRedirect(route('admin.admin_users.index'))
            ->assertSessionHas('success');

        $response = $this->adminUserRepository->getByUserId(new AdminUserId($params['user_id']));

        $this->assertTrue(
            $response->getUserId()->isEqual($params['user_id'])
        );

        $this->get(route('admin.auth.logout'));

        $this->post(route('admin.auth.login'), [
            'user_id' => 'takada_yuki_test',
            'password' => 'test_takada_yuki_pass',
        ])->assertRedirect(route('admin.top_page'));
    }

    public function testDestroy()
    {
        $response = $this->adminUserRepository->getByUserId(new AdminUserId('takada_yuki'));

        $this->delete(route('admin.admin_users.destroy', $response->getId()))
            ->assertRedirect(route('admin.admin_users.index'))
            ->assertSessionHas('success');

        $this->expectException(NotFoundException::class);
        $this->adminUserRepository->getByUserId(new AdminUserId('takada_yuki'));
    }
}
