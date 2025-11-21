<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\WorkExperience;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PrintWorkExperienceSheetTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_print_work_experience_sheet()
    {
        $user = User::factory()->create();
        $workExperience = WorkExperience::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('wes.print'));

        $response->assertOk();
        $response->assertInertia(fn ($page) => $page
            ->component('Profile/WorkExperienceSheet/Print')
            ->has('experiences', 1)
        );
    }
}
