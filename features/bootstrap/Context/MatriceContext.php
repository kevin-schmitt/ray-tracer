<?php

declare(strict_types=1);

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use RayTracer\Math\Matrix;
use RayTracer\Model\Tuple;
use RayTracer\Utils\Comparator;

class MatriceContext implements Context
{
    use ArrayHelperTrait;
    use BehatTransformTrait;

    /**
     * @var array<Matrix>
     */
    private array $matrices;
    /**
     * @var array<Tuple>
     */
    private array $tuples;

    /**
     * @Given the following matrix 4x4 M:
     * @Given the following matrix A:
     * @Given the following matrix B:
     */
    public function theFollowingMatrixXM(TableNode $matrix)
    {
        $this->matrices[] = Matrix::fromTableNode($matrix);
    }

    /**
     * @Then M[:arg1] = :value
     */
    public function m(string $positions, float $value)
    {
        [$x, $y] = array_map('intval', explode(',', $positions));
        Assertion::eq($value, $this->matrices[0]->element($x, $y));
    }

    /**
     * @Then A = B
     * @Then A = identify_matrix
     */
    public function equalTo()
    {
        Assertion::true($this->matrices[0]->equalTo($this->matrices[1]));
    }

    /**
     * @Then A != B
     */
    public function notEqualTo()
    {
        Assertion::false($this->matrices[0]->equalTo($this->matrices[1]));
    }

    /**
     * @Then A * B is the following matrix:
     */
    public function aBIsTheFollowingmatrix(TableNode $matrix)
    {
        $matrixExcepted = Matrix::fromTableNode($matrix);
        $matrixResult = $this->matrices[0]->multiply($this->matrices[1]);

        Assertion::true($matrixResult->equalTo($matrixExcepted));
    }

    /**
     * @Given the tuple b <- (:tuple)
     * @Given the tuple a <- (:tuple)
     */
    public function theTupleAffectation(string $tuple)
    {
        $this->tuples[] = Tuple::from(...$this->stringToArrayFloat($tuple));
    }

    /**
     * @Then matrix A * b = tuple(:tuple)
     */
    public function matrixABTuple(string $tupleExcepted)
    {
        $tupleExcepted = Tuple::from(...$this->stringToArrayFloat($tupleExcepted));
        $tupleResult = $this->matrices[0]->multiplyByTuple($this->tuples[0]);

        Assertion::true(Comparator::float($tupleExcepted->getX(), $tupleResult->getX()));
        Assertion::true(Comparator::float($tupleExcepted->getY(), $tupleResult->getY()));
        Assertion::true(Comparator::float($tupleExcepted->getZ(), $tupleResult->getZ()));
        Assertion::true(Comparator::float($tupleExcepted->getW(), $tupleResult->getW()));
    }

    /**
     * @Then A * identify = A
     */
    public function aIdentifyA()
    {
        $matrixIdentify = Matrix::identify($this->matrices[0]->size());
        $matrixResult = $this->matrices[0]->multiply($matrixIdentify);

        Assertion::true($this->matrices[0]->equalTo($matrixResult));
    }

    /**
     * @Then identify_matrix * a = a
     */
    public function identifyMatrixAA()
    {
        $matrixIdentify = Matrix::identify(4);
        $tupleExcepted = $matrixIdentify->multiplyByTuple($this->tuples[0]);

        Assertion::true(Comparator::float($tupleExcepted->getX(), $this->tuples[0]->getX()));
        Assertion::true(Comparator::float($tupleExcepted->getY(), $this->tuples[0]->getY()));
        Assertion::true(Comparator::float($tupleExcepted->getZ(), $this->tuples[0]->getZ()));
        Assertion::true(Comparator::float($tupleExcepted->getW(), $this->tuples[0]->getW()));
    }

    /**
     * @Then transpose is the following matrix:
     */
    public function transposeIsTheFollowingMatrix(TableNode $matrixExcepted)
    {
        $matrixExcepted = Matrix::fromTableNode($matrixExcepted);
        $matrixResult = $this->matrices[0]->transpose();

        Assertion::true($matrixResult->equalTo($matrixExcepted));
    }

    /**
     * @Given A <- transpose->identify_matrix
     */
    public function aTransposeIdentifyMatrix2()
    {
        $matrix = Matrix::identify(4);
        $this->matrices[] = $matrix;
        $this->matrices[] = $matrix->transpose();
    }

    /**
     * @Then determinant(:name) = :determinantExcepted
     */
    public function determinant(string $name = '', float $determinantExcepted)
    {
        $matrice = ('B' === $name) ? $this->matrices[1] : $this->matrices[0];
        Assertion::true(Comparator::float($matrice->determinant(), $determinantExcepted));
    }

    /**
     * @Then submatrix(:row, :colum) is the following 2x2 matrix:
     * @Then submatrix(:row, :colum) is the following 3x3 matrix:
     */
    public function submatrixIsTheFollowingXMatrix(int $row, int $column, TableNode $matrixExcepted)
    {
        $matrixExcepted = Matrix::fromTableNode($matrixExcepted);
        $matrixResult = $this->matrices[0]->submatrix($row, $column);

        Assertion::true($matrixResult->equalTo($matrixExcepted));
    }

    /**
     * @Given B <- submatrix(A, :row, :column)
     */
    public function submatrixAffectation(int $row, int $column)
    {
        $this->matrices[1] = $this->matrices[0]->submatrix($row, $column);
    }

    /**
     * @Then minor(A, :row, :column) = :minor
     */
    public function thenMinor(int $row, int $column, int $minorExcepted)
    {
        $minor = $this->matrices[0]->minor($row, $column);
        Assertion::eq($minorExcepted, $minor);
    }

    /**
     * @Then cofactor(:matrixName, :row, :column) = :cofactorExcepted
     */
    public function cofactorA(int $row, int $column, int $cofactorExcepted)
    {
        Assertion::eq($this->matrices[0]->cofactor($row, $column), $cofactorExcepted);
    }

    /**
     * @Then A is invertible
     */
    public function aIsInvertible()
    {
        Assertion::true($this->matrices[0]->invertible());
    }

    /**
     * @Then A is not invertible
     */
    public function aIsNotInvertible()
    {
        Assertion::false($this->matrices[0]->invertible());
    }

    /**
     * @Given B <- inverse(:matrixName)
     */
    public function bInverseA()
    {
        $this->matrices[] = $this->matrices[0]->inverse();
    }

    /**
     * @Then B[:params] = :cofactor\/:determinant
     */
    public function CofactorByDterminant(string $params, int $cofactor, int $determinant)
    {
        [$col, $row] = $this->stringToArrayInt($params);
        Assertion::eq($this->matrices[0]->cofactor($row, $col) / $this->matrices[0]->determinant(), $cofactor / $determinant);
    }

    /**
     * @Then B is the following matrix:
     */
    public function bIsTheFollowingMatrix(TableNode $table)
    {
        $matrixExcepted = Matrix::fromTableNode($table);
        Assertion::true($this->matrices[1]->equalTo($matrixExcepted));
    }

    /**
     * @Given C <- A * B
     */
    public function cEqualAMultipliedByB()
    {
        $this->matrices[] = $this->matrices[0]->multiply($this->matrices[1]);
    }

    /**
     * @Then C * inverse(:matrixName) = A
     */
    public function cMultplyByInverseEquals()
    {
        Assertion::true(
            $this->matrices[2]
                ->multiply($this->matrices[1]->inverse())
                ->equalTo($this->matrices[0])
        );
    }
}
