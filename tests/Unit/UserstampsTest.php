<?php

namespace Sqits\UserStamps\Tests\Unit;

use Sqits\UserStamps\Tests\Models\LaravelUserstamp;
use Sqits\UserStamps\Tests\Models\User;
use Sqits\UserStamps\Tests\TestCase;

class UserstampsTest extends TestCase
{
    /**
     * Test if a model can be created and the created_by is set correctly
     *
     * @test
     * @return void
     */
    public function it_can_create_a_model_with_created_by()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'laravel@userstamps.dev'
        ]);

        $this->actingAs($user);

        $model = LaravelUserstamp::create([
            'name' => 'it_can_create_a_model_with_created_by_test'
        ]);

        $this->assertArrayHasKey('created_by', $model);
        $this->assertEquals(1, $model->created_by);
        $this->assertEquals('laravel@userstamps.dev', $model->author->email);
    }

    /**
     * Test if a model can be updated and the updated_by is set correctly
     *
     * @test
     * @return void
     */
    public function it_can_update_a_model_with_updated_by()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'laravel@userstamps.dev'
        ]);

        $this->actingAs($user);

        $model = LaravelUserstamp::create([
            'name' => 'it_can_create_a_model_with_created_by_test'
        ]);

        $model->name = 'it_can_update_a_model_with_updated_by';
        $model->save();

        $this->assertArrayHasKey('updated_by', $model);
        $this->assertEquals(1, $model->updated_by);
        $this->assertEquals('laravel@userstamps.dev', $model->editor->email);
    }

    /**
     * Test if a model can be deleted and the deleted_by is set correctly
     *
     * @test
     * @return void
     */
    public function it_can_delete_a_model_with_deleted_by()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'laravel@userstamps.dev'
        ]);

        $this->actingAs($user);

        $model = LaravelUserstamp::create([
            'name' => 'it_can_delete_a_model_with_deleted_by'
        ]);

        $model->delete();

        $this->assertArrayHasKey('deleted_by', $model->toArray());
        $this->assertEquals(1, $model->deleted_by);
        $this->assertEquals('laravel@userstamps.dev', $model->destroyer->email);
    }

    /**
     * Test if a model can be deleted and the deleted_by is set correctly
     *
     * @test
     * @return void
     */
    public function it_can_restore_a_model_with_deleted_by()
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'laravel@userstamps.dev'
        ]);

        $this->actingAs($user);

        $model = LaravelUserstamp::create([
            'name' => 'it_can_delete_a_model_with_deleted_by'
        ]);

        $model->delete();

        $model->restore();

        $this->assertArrayHasKey('deleted_by', $model->toArray());
        $this->assertEquals(null, $model->deleted_by);
        $this->assertEquals(null, $model->destroyer);
    }
}
