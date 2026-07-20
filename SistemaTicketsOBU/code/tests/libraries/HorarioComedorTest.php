<?php

use App\Libraries\HorarioComedor;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class HorarioComedorTest extends CIUnitTestCase
{
    public function testDesayunoDentroDeRango()
    {
        $this->assertSame(1, HorarioComedor::turnoActual('07:00:00', 1));
        $this->assertSame(1, HorarioComedor::turnoActual('08:15:00', 1));
        $this->assertSame(1, HorarioComedor::turnoActual('09:30:00', 1));
    }

    public function testAlmuerzoDentroDeRango()
    {
        $this->assertSame(2, HorarioComedor::turnoActual('12:00:00', 1));
        $this->assertSame(2, HorarioComedor::turnoActual('13:30:00', 1));
        $this->assertSame(2, HorarioComedor::turnoActual('14:00:00', 1));
    }

    public function testCenaDentroDeRango()
    {
        $this->assertSame(3, HorarioComedor::turnoActual('17:00:00', 1));
        $this->assertSame(3, HorarioComedor::turnoActual('18:30:00', 1));
        $this->assertSame(3, HorarioComedor::turnoActual('19:00:00', 1));
    }

    public function testFueraDeTodosLosRangos()
    {
        $this->assertNull(HorarioComedor::turnoActual('06:59:59', 1));
        $this->assertNull(HorarioComedor::turnoActual('09:30:01', 1));
        $this->assertNull(HorarioComedor::turnoActual('11:59:59', 1));
        $this->assertNull(HorarioComedor::turnoActual('14:00:01', 1));
        $this->assertNull(HorarioComedor::turnoActual('16:59:59', 1));
        $this->assertNull(HorarioComedor::turnoActual('19:00:01', 1));
        $this->assertNull(HorarioComedor::turnoActual('23:00:00', 1));
    }

    public function testSinServicioElFinDeSemana()
    {
        // Sábado (6) y domingo (7), aunque la hora caiga en un turno válido
        $this->assertNull(HorarioComedor::turnoActual('13:00:00', 6));
        $this->assertNull(HorarioComedor::turnoActual('13:00:00', 7));
    }

    public function testEsDiaHabil()
    {
        foreach ([1, 2, 3, 4, 5] as $dia) {
            $this->assertTrue(HorarioComedor::esDiaHabil($dia));
        }
        foreach ([6, 7] as $dia) {
            $this->assertFalse(HorarioComedor::esDiaHabil($dia));
        }
    }

    public function testNombre()
    {
        $this->assertSame('Desayuno', HorarioComedor::nombre(1));
        $this->assertSame('Almuerzo', HorarioComedor::nombre(2));
        $this->assertSame('Cena', HorarioComedor::nombre(3));
        $this->assertNull(HorarioComedor::nombre(99));
    }
}
