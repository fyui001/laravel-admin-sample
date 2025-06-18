<?php

declare(strict_types=1);

namespace Tests\Feature\Admin;

use Domain\ReleaseFlag\ReleaseFlagName;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Feature\FeatureTestCase;

class ReleaseFlagControllerTest extends FeatureTestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminLogin();
    }

    public function testIndex()
    {
        $this->get(route('admin.release_flags.index'))->assertOk();
    }

    public function testEdit()
    {
        $route = route(
            'admin.release_flags.edit',
            ['name' => ReleaseFlagName::TEST->getValue()->getRawValue()]
        );
        $this->get($route)->assertOk();
    }

    public function testUpdateEnable()
    {
        $params = [
            'is_enabled' => true,
        ];

        $this->post(
            route(
                'admin.release_flags.update',
                ['name' => ReleaseFlagName::TEST->getValue()->getRawValue()]
            ),
            $params
        )
            ->assertRedirect(route('admin.release_flags.index'))
            ->assertSessionHas('success');
    }

    public function testUpdateDisable()
    {
        $params = [
            'is_enabled' => false,
        ];

        $this->post(
            route(
                'admin.release_flags.update',
                ['name' => ReleaseFlagName::TEST->getValue()->getRawValue()]
            ),
            $params
        )
            ->assertRedirect(route('admin.release_flags.index'))
            ->assertSessionHas('success');
    }
}
