<?php


namespace Tests\Feature\Modules\Achievements\Admin;

use Tests\TestCase;

class CreateTest extends TestCase
{
    public function test_unauthenticated_cannot_create_achievement()
    {
//        $response = $this->json('POST', )

    }

    public function test_authenticated_can_create_achievement()
    {
        $token = $this->getToken();
    }
}
