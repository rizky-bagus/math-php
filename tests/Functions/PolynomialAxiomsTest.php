<?php
namespace MathPHP\Tests\Functions;

use MathPHP\Functions\Polynomial;

/**
 * Tests of polynomial axioms
 * These tests don't test specific functions,
 * but rather polynomial axioms which in term make use of multiple functions.
 * If all the polynomial math is implemented properly, these tests should
 * all work out according to the axioms.
 *
 * Axioms tested:
 *  - Commutativity
 *    - a + b = b + a
 *    - ab = bc
 *  - Associativity
 *    - a + (b + c) = (a + b) + c
 *    - a(bc) = (ab)c
 *  - Distributed Law
 *    - a ✕ (b + c) = a ✕ b + a ✕ c
 *    - a + (b ✕ c) = a ✕ c + b ✕ c
 *  - Identity
 *    - a + 0 = 0 + a = a
 *    - a ✕ 0 = 0 ✕ a = 0
 *  - Negate
 *    - -a = a * -1
 */
class PolynoialAxiomsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @testCase Axiom: a + b = b + a
     * Commutativity of addition.
     * @dataProvider dataProviderForTwoPolynomials
     * @param        array $a
     * @param        array $b
     */
    public function testCommutativityOfAddition($a, $b)
    {
        $a = new Polynomial($a);
        $b = new Polynomial($b);

        $a＋b = $a->add($b);
        $b＋a = $b->add($a);

        $this->assertEquals($a＋b->getDegree(), $b＋a->getDegree());
        $this->assertEquals($a＋b->getCoefficients(), $b＋a->getCoefficients());
    }

    /**
     * @testCase Axiom: ab = bc
     * Commutativity of multiplication.
     * @dataProvider dataProviderForTwoPolynomials
     * @param        array $a
     * @param        array $b
     */
    public function testCommutativityOfMultiplication($a, $b)
    {
        $a = new Polynomial($a);
        $b = new Polynomial($b);

        $ab = $a->multiply($b);
        $ba = $b->multiply($a);

        $this->assertEquals($ab->getDegree(), $ba->getDegree());
        $this->assertEquals($ab->getCoefficients(), $ba->getCoefficients());
    }

    /**
     * @testCase Axiom: a + (b + c) = (a + b) + c
     * Associativity of addition.
     * @dataProvider dataProviderForThreePolynomials
     * @param        array $a
     * @param        array $b
     * @param        array $c
     */
    public function testAssociativityOfAddition($a, $b, $c)
    {
        $a = new Polynomial($a);
        $b = new Polynomial($b);
        $c = new Polynomial($c);

        $a ＋ ⟮b ＋ c⟯ = $a->add($b->add($c));
        $⟮a ＋ b⟯ ＋ c = ($a->add($b))->add($c);

        $this->assertEquals($a ＋ ⟮b ＋ c⟯->getDegree(), $⟮a ＋ b⟯ ＋ c->getDegree());
        $this->assertEquals($a ＋ ⟮b ＋ c⟯->getCoefficients(), $⟮a ＋ b⟯ ＋ c->getCoefficients());
    }

    /**
     * @testCase Axiom: a(bc) = (ab)c
     * Associativity of multiplication.
     * @dataProvider dataProviderForThreePolynomials
     * @param        array $a
     * @param        array $b
     * @param        array $c
     */
    public function testAssociativityOfMultiplication($a, $b, $c)
    {
        $a = new Polynomial($a);
        $b = new Polynomial($b);
        $c = new Polynomial($c);

        $a⟮bc⟯ = $a->multiply($b->multiply($c));
        $⟮ab⟯c = ($a->multiply($b))->multiply($c);

        $this->assertEquals($a⟮bc⟯->getDegree(), $⟮ab⟯c->getDegree());
        $this->assertEquals($a⟮bc⟯->getCoefficients(), $⟮ab⟯c->getCoefficients());
    }

    /**
     * @testCase Axiom: a ✕ (b + c) = a ✕ b + a ✕ c
     * Distributive law.
     * @dataProvider dataProviderForThreePolynomials
     * @param        array $a
     * @param        array $b
     * @param        array $c
     */
    public function testDistributiveLaw1($a, $b, $c)
    {
        $a = new Polynomial($a);
        $b = new Polynomial($b);
        $c = new Polynomial($c);

        $a⟮b ＋ c⟯   = $a->multiply($b->add($c));
        $⟮ab⟯ ＋ ⟮ac⟯ = ($a->multiply($b))->add($a->multiply($c));

        $this->assertEquals($a⟮b ＋ c⟯->getDegree(), $⟮ab⟯ ＋ ⟮ac⟯->getDegree());
        $this->assertEquals($a⟮b ＋ c⟯->getCoefficients(), $⟮ab⟯ ＋ ⟮ac⟯->getCoefficients());
    }

    /**
     * @testCase Axiom: (a + b) ✕ c = a ✕ c + b ✕ c
     * Distributive law.
     * @dataProvider dataProviderForThreePolynomials
     * @param        array $a
     * @param        array $b
     * @param        array $c
     */
    public function testDistributiveLaw2($a, $b, $c)
    {
        $a = new Polynomial($a);
        $b = new Polynomial($b);
        $c = new Polynomial($c);

        $⟮a ＋ b⟯c   = ($a->add($b))->multiply($c);
        $⟮ac⟯ ＋ ⟮bc⟯ = ($a->multiply($c))->add($b->multiply($c));

        $this->assertEquals($⟮a ＋ b⟯c->getDegree(), $⟮ac⟯ ＋ ⟮bc⟯->getDegree());
        $this->assertEquals($⟮a ＋ b⟯c->getCoefficients(), $⟮ac⟯ ＋ ⟮bc⟯->getCoefficients());
    }

    /**
     * @testCase Axiom: a + 0 = 0 + a = a
     * Identity of addition.
     * @dataProvider dataProviderForOnePolynomial
     * @param        array $a
     */
    public function testIdentityOfAddition($a)
    {
        $a = new Polynomial($a);

        $zero    = new Polynomial([0]);
        $a＋0    = $a->add($zero);
        $zero＋a = $zero->add($a);

        $this->assertEquals($a->getDegree(), $a＋0->getDegree());
        $this->assertEquals($a->getDegree(), $zero＋a->getDegree());

        $this->assertEquals($a->getCoefficients(), $a＋0->getCoefficients());
        $this->assertEquals($a->getCoefficients(), $zero＋a->getCoefficients());
    }

    /**
     * @testCase Axiom: a ✕ 0 = 0 ✕ a = 0
     * Identity of multiplication.
     * @dataProvider dataProviderForOnePolynomial
     * @param        array $a
     */
    public function testIdentityOfMultiplication($a)
    {
        $a = new Polynomial($a);

        $zero   = new Polynomial([0]);
        $a✕0    = $a->multiply($zero);
        $zero✕a = $zero->multiply($a);

        $this->assertEquals($zero->getDegree(), $a✕0->getDegree());
        $this->assertEquals($zero->getDegree(), $zero✕a->getDegree());

        $this->assertEquals($zero->getCoefficients(), $a✕0->getCoefficients());
        $this->assertEquals($zero->getCoefficients(), $zero✕a->getCoefficients());
    }

    /**
     * @testCase Axiom: -a = a * -1
     * Negation is the same as multiplying by -1
     * @dataProvider dataProviderForOnePolynomial
     * @param        array $a
     */
    public function testNegateSameAsMultiplyingByNegativeOne(array $a)
    {
        $a = new Polynomial($a);

        $−a = $a->negate();
        $a⟮−1⟯ = $a->multiply(-1);

        $this->assertEquals($−a->getDegree(), $a⟮−1⟯->getDegree());
        $this->assertEquals($−a->getCoefficients(), $a⟮−1⟯->getCoefficients());
    }

    public function dataProviderForOnePolynomial(): array
    {
        return [
            [
                [0],
            ],
            [
                [1],
            ],
            [
                [2],
            ],
            [
                [8],
            ],
            [
                [1, 5],
            ],
            [
                [4, 0],
            ],
            [
                [0, 3],
            ],
            [
                [12, 4],
            ],
            [
                [1, 2, 3],
            ],
            [
                [2, 3, 4],
            ],
            [
                [1, 1, 1],
            ],
            [
                [5, 3, 6],
            ],
            [
                [2, 7, 4],
            ],
            [
                [6, 0, 3],
            ],
            [
                [4, 5, 2, 6],
            ],
            [
                [3, 5, 2, 10],
            ],
            [
                [-4, 6, 7, -1],
            ],
            [
                [-2, -1, -4, -3],
            ],
            [
                [5, 3, 6],
            ],
            [
                [7, 6, 6],
            ],
            [
                [-6, -1],
            ],
            [
                [-5, -5, -1, 2, 4, 6, 5],
            ],
            [
                [10, 20, 30, 40],
            ],
            [
                [-5, 10, -15, 20, -55],
            ],
            [
                [0, 0, 0, 0, 5],
            ],
            [
                [2, 0, 0, 0, 4],
            ],
            [
                [-1, -2, -3, -4, -5, -6, -7, -8, -9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
            ],
            [
                [4, 54, 23, -34, 12, 73, -34, 2],
            ],
        ];
    }

    public function dataProviderForTwoPolynomials(): array
    {
        return [
            [
                [0],
                [0],
            ],
            [
                [1],
                [1],
            ],
            [
                [0],
                [1],
            ],
            [
                [1],
                [0],
            ],
            [
                [2],
                [2],
            ],
            [
                [1],
                [2],
            ],
            [
                [4],
                [8],
            ],
            [
                [1, 5],
                [5, 4],
            ],
            [
                [4, 0],
                [5, 6],
            ],
            [
                [0, 3],
                [5, 5],
            ],
            [
                [12, 4],
                [5, 10],
            ],
            [
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                [1, 2, 3],
                [2, 3, 4],
            ],
            [
                [1, 1, 1],
                [2, 2, 2],
            ],
            [
                [5, 3, 6],
                [8, 7, 3],
            ],
            [
                [2, 7, 4],
                [5, 4, 7],
            ],
            [
                [6, 0, 3],
                [1, 1, 2],
            ],
            [
                [4, 5, 2, 6],
                [6, 5, 5, 4],
            ],
            [
                [3, 5, 2, 10],
                [2, -2, 5, 3],
            ],
            [
                [-4, 6, 7, -1],
                [5, 5, -5, -1],
            ],
            [
                [-2, -1, -4, -3],
                [-5, 5, -4, -3],
            ],
            [
                [1],
                [5, 3, 6],
            ],
            [
                [7, 6, 6],
                [3, 2],
            ],
            [
                [-3, 4, 5, 6],
                [-6, -1],
            ],
            [
                [5, 6, 7, 6, 5, 6],
                [-5, -5, -1, 2, 4, 6, 5],
            ],
            [
                [10, 20, 30, 40],
                [-4, 5, 6, -4, 3],
            ],
            [
                [4, 8, 12, 16, 20],
                [-5, 10, -15, 20, -55],
            ],
            [
                [0, 0, 0, 0, 5],
                [4, 3, 6, 7],
            ],
            [
                [2, 0, 0, 0, 4],
                [1, 1, 1, 1, 1],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [-1, -2, -3, -4, -5, -6, -7, -8, -9],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [2, 3, 4, 5, 6, 7, 8, 9, 10],
            ],
            [
                [34, 65, 34, 23, 62, 87, 34, 65],
                [4, 54, 23, -34, 12, 73, -34, 2],
            ],
        ];
    }

    public function dataProviderForThreePolynomials(): array
    {
        return [
            [
                [0],
                [0],
                [0],
            ],
            [
                [1],
                [1],
                [1],
            ],
            [
                [0],
                [1],
                [0],
            ],
            [
                [1],
                [0],
                [1],
            ],
            [
                [2],
                [2],
                [2],
            ],
            [
                [1],
                [2],
                [3],
            ],
            [
                [4],
                [8],
                [2],
            ],
            [
                [1, 5],
                [5, 4],
                [4, 3],
            ],
            [
                [4, 0],
                [5, 6],
                [6, 5],
            ],
            [
                [0, 3],
                [5, 5],
                [0, 0],
            ],
            [
                [12, 4],
                [5, 10],
                [2, 10],
            ],
            [
                [1, 2, 3],
                [1, 2, 3],
                [1, 2, 3],
            ],
            [
                [1, 2, 3],
                [2, 3, 4],
                [3, 4, 5],
            ],
            [
                [1, 1, 1],
                [2, 2, 2],
                [3, 3, 3],
            ],
            [
                [5, 3, 6],
                [8, 7, 3],
                [3, 2, 7],
            ],
            [
                [2, 7, 4],
                [5, 4, 7],
                [6, 5, 4],
            ],
            [
                [6, 0, 3],
                [1, 1, 2],
                [2, 3, 0],
            ],
            [
                [4, 5, 2, 6],
                [6, 5, 5, 4],
                [2, 2, 3, 3],
            ],
            [
                [3, 5, 2, 10],
                [2, -2, 5, 3],
                [-1, 3, 4, -1],
            ],
            [
                [-4, 6, 7, -1],
                [5, 5, -5, -1],
                [6, 5, -4, -3],
            ],
            [
                [-2, -1, -4, -3],
                [-5, 5, -4, -3],
                [1, -1, 1, -2],
            ],
            [
                [1],
                [5, 3, 6],
                [3, -2],
            ],
            [
                [7, 6, 6],
                [3, 2],
                [4],
            ],
            [
                [-3, 4, 5, 6],
                [-6, -1],
                [5, 6, 4],
            ],
            [
                [5, 6, 7, 6, 5, 6],
                [-5, -5, -1, 2, 4, 6, 5],
                [5, 5, 5, -6, -6, -4, 3],
            ],
            [
                [10, 20, 30, 40],
                [-4, 5, 6, -4, 3],
                [-3, -3, -2, 1, 5],
            ],
            [
                [4, 8, 12, 16, 20],
                [-5, 10, -15, 20, -55],
                [3, 6, 9, -12, -15],
            ],
            [
                [0, 0, 0, 0, 5],
                [4, 3, 6, 7],
                [6, 0, 0, 0, 0],
            ],
            [
                [2, 0, 0, 0, 4],
                [1, 1, 1, 1, 1],
                [2, 2, 2, -3, -2]
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [-1, -2, -3, -4, -5, -6, -7, -8, -9],
                [4, 3, 5, 6],
            ],
            [
                [1, 2, 3, 4, 5, 6, 7, 8, 9],
                [2, 3, 4, 5, 6, 7, 8, 9, 10],
                [3, 4, 5, 6, 7, 8, 9, 10, 11],
            ],
            [
                [34, 65, 34, 23, 62, 87, 34, 65],
                [4, 54, 23, -34, 12, 73, -34, 2],
                [34, 23, 12, 63, 24, -42, 12, 4],
            ],
            [
                [1, 2, 3, 4, 5, 6],
                [-1, -2, -3, -4, -6],
                [0, 0, 0, 0, 0, 0],
            ],
        ];
    }
}
