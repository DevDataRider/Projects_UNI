<?php

use App\Filters\AdminOnlyFilter;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Test\CIUnitTestCase;
use Config\App;
use Config\Services;

/**
 * @internal
 */
final class AdminOnlyFilterTest extends CIUnitTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        session()->destroy();
    }

    public function testBlocksStudentProfile()
    {
        session()->set('perfil', 'Estudiante');

        $filter  = new AdminOnlyFilter();
        $request = Services::incomingrequest(new App(), false);

        $result = $filter->before($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function testBlocksMissingProfile()
    {
        $filter  = new AdminOnlyFilter();
        $request = Services::incomingrequest(new App(), false);

        $result = $filter->before($request);

        $this->assertInstanceOf(RedirectResponse::class, $result);
    }

    public function testAllowsAdminProfile()
    {
        session()->set('perfil', 'Administrador');

        $filter  = new AdminOnlyFilter();
        $request = Services::incomingrequest(new App(), false);

        $result = $filter->before($request);

        $this->assertNull($result);
    }
}
