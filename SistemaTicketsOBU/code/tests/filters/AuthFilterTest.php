<?php

use App\Filters\AuthFilter;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Test\CIUnitTestCase;
use Config\App;
use Config\Services;

/**
 * @internal
 */
final class AuthFilterTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        session()->destroy();
    }

    public function testBlocksAnonymousRequest()
    {
        $filter  = new AuthFilter();
        $request = Services::incomingrequest(new App(), false);

        $result = $filter->before($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function testAllowsLoggedInRequest()
    {
        session()->set('isLoggedIn', true);

        $filter  = new AuthFilter();
        $request = Services::incomingrequest(new App(), false);

        $result = $filter->before($request);

        $this->assertNull($result);
    }
}
