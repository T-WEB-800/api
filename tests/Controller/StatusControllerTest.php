<?php

namespace Tests\Controller;

use App\Controller\StatusController;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

#[CoversClass(StatusController::class)]
class StatusControllerTest extends TestCase {
    private StatusController $statusController;

    protected function setUp(): void
    {
        $this->statusController = new StatusController();
    }

    #[Test]
    public function ok_should_respond_with_200(): void
    {
        self::assertEquals(new JsonResponse(null, 200), $this->statusController->status());
    }
}