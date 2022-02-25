<?php

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use RayTracer\Color\Color;
use RayTracer\Color\ColorCalculator;
use RayTracer\Model\Tuple;
use RayTracer\Model\TupleFactory;
use RayTracer\Model\TupleInterface;
use RayTracer\Utils\Comparator;

/**
 * Defines application features from the specific context.
 */
class TupleContext implements Context
{
    use ArrayHelperTrait;
    private TupleInterface $tuple;
    private TupleInterface $tuple2;

    /**
     * @var array<Color>
     */
    private array $colors;

    /**
     * @Given a <- Tuples(:tuples)
     * @Given a <- tuple(:tuples)
     */
    public function tupleCreation(string $tuples): void
    {
        $tupleArray = $this->stringToArrayFloat($tuples);
        $this->tuple = new Tuple(...$tupleArray);
    }

    /**
     * @Given p <- point(:tuple)
     * @Given p1 <- point(:tuple)
     */
    public function pointCreation(string $tuple): void
    {
        $tuple = sprintf('%s, %s', $tuple, '1');
        $tupleArray = $this->stringToArrayFloat($tuple);
        $this->tuple = TupleFactory::create(...$tupleArray);
    }

    /**
     * @Given p2 <- point(:tuple)
     */
    public function point2Creation(string $tuple): void
    {
        $tuple = sprintf('%s, %s', $tuple, '1');
        $tupleArray = $this->stringToArrayFloat($tuple);
        $this->tuple2 = TupleFactory::create(...$tupleArray);
    }

    /**
     * @Given p <- vector(:x, :y, :z)
     * @Given v1 <- vector(:x, :y, :z)
     * @Given zero <- vector(:x, :y, :z)
     * @Given v <- vector(:x, :y, :z)
     * @Given a <- vector(:x, :y, :z)
     */
    public function vectorCreation(float $x, float $y, float $z): void
    {
        $this->tuple = Tuple::vector($x, $y, $z);
    }

    /**
     * @Given p <- vector(:x, :y, :z, :w)
     * @Given a1 <- tuple(:x, :y, :z, :w)
     * @Given a <- vector(:x, :y, :z, :w)
     */
    public function vectorCreationWithW(float $x, float $y, float $z, float $w): void
    {
        $this->tuple = TupleFactory::create($x, $y, $z, $w);
    }

    /**
     * @Given v2 <- vector(:x, :y, :z)
     * @Given b <- vector(:x, :y, :z)
     * @Given n <- vector(:x, :y, :z)
     */
    public function vector2Creation(float $x, float $y, float $z): void
    {
        $this->tuple2 = Tuple::vector($x, $y, $z);
    }

    /**
     * @Given a2 <- tuple(:tuple)
     */
    public function tuple2Creation(string $tuple): void
    {
        $this->tuple2 = TupleFactory::create(...$this->stringToArrayFloat($tuple));
    }

    /**
     * @Then a1 + a2  = tuple(:tuple)
     */
    public function additionTuple(string $tuple): void
    {
        $this->tuple->add($this->tuple2);
        $this->tupleEqualsArrayValues($tuple);
    }

    /**
     * @Then p1 - p2 = vector(:vector)
     * @Then zero - v2 = vector(:vector)
     */
    public function substrEqualTo(string $vector): void
    {
        $this->tuple->substr($this->tuple2);
        $vector = sprintf('%s, %s', $vector, 0);
        $this->tupleEqualsArrayValues($vector);
    }

    /**
     * @Then v1 - v2 = point(:point)
     */
    public function substrPoinrEqualTo(string $point): void
    {
        $this->tuple->substr($this->tuple2);
        $point = sprintf('%s, %s', $point, 0);
        $this->tupleEqualsArrayValues($point);
    }

    /**
     * @Then v1 - p2 = point(:point)
     */
    public function p1SubstrP2EqualToPoint(string $point): void
    {
        $this->tuple->substr($this->tuple2);
        $point = sprintf('%s, %s', $point, 1);
        $this->tupleEqualsArrayValues($point);
    }

    /**
     * @Then p = tuple(:tuple)
     */
    public function tupleEqualsArrayValues(string $tuple): void
    {
        $tupleArray = $this->stringToArrayFloat($tuple);
        Assertion::same(true, Comparator::float($this->tuple->getX(), $tupleArray[0]));
        Assertion::same(true, Comparator::float($this->tuple->getY(), $tupleArray[1]));
        Assertion::same(true, Comparator::float($this->tuple->getZ(), $tupleArray[2]));

        if (isset($tupleArray[3])) {
            Assertion::eq($this->tuple->getW(), $tupleArray[3]);
        }
    }

    /**
     * @Then a.x=:x
     */
    public function aEqualToX(float $x): void
    {
        Assertion::eq($x, $this->tuple->getX());
    }

    /**
     * @Then a.y=:y
     */
    public function aEqualToY(float $y): void
    {
        Assertion::eq($y, $this->tuple->getY());
    }

    /**
     * @Then a.z=:z
     */
    public function aEqualToZ(float $z): void
    {
        Assertion::eq($z, $this->tuple->getZ());
    }

    /**
     * @Then a.w=:w
     */
    public function aIsEqualToW(float $w): void
    {
        Assertion::eq($w, $this->tuple->getW());
    }

    /**
     * @Then a is a point
     */
    public function aIsAPoint(): void
    {
        Assertion::eq($this->tuple->getType(), 'point');
    }

    /**
     * @Then a is not a vector
     */
    public function aIsNotAVector(): void
    {
        Assertion::notEq($this->tuple->getType(), 'vector');
    }

    /**
     * @Then a is a vector
     */
    public function aIsAVector(): void
    {
        Assertion::eq($this->tuple->getType(), 'vector');
    }

    /**
     * @Then a is not a point
     */
    public function aIsNotAPoint(): void
    {
        Assertion::notEq($this->tuple->getType(), 'point');
    }

    /**
     * @Then -a = vector(:x, :y, :z, :w)
     */
    public function aVector(float $x, float $y, float $z, float $w): void
    {
        Assertion::true($this->tuple->negate()->equalTo(Tuple::from($x, $y, $z, $w)));
    }

    /**
     * @Then magnitude = :magnitudeExcepted
     */
    public function magnitudeV(float $magnitudeExcepted): void
    {
        Assertion::true(Comparator::float($this->tuple->getMagnitude(), $magnitudeExcepted));
    }

    /**
     * @Then a * :coef = tuple(:tuple)
     */
    public function thenAMultiplyToCoefEqualsTo(float $coef, string $tuple): void
    {
        $tuple = TupleFactory::create(...$this->stringToArrayFloat($tuple));
        Assertion::true($this->tuple->multiplyBy($coef)->equalTo($tuple));
    }

    /**
     * @Then a \/ :coef = tuple(:tuple)
     */
    public function aTuple3(float $coef, string $tuple): void
    {
        $this->tuple->dividingBy($coef);
        $this->tupleEqualsArrayValues($tuple);
    }

    /**
     * @Then normalize = vector(:x, :y, :z)
     * @Then normalize = apprixomately vector(:x, :y, :z)
     */
    public function normalizeVector(float $x, float $y, float $z): void
    {
        $vectorExcepted = Tuple::vector($x, $y, $z);
        Assertion::true($this->tuple->normalize()->equalTo($vectorExcepted));
    }

    /**
     * @When norm <- normalize
     */
    public function normNormalizeV(): void
    {
        $this->tuple = $this->tuple->normalize();
    }

    /**
     * @Then dot = :value
     */
    public function dot(float $dotExcepted): void
    {
        $dot = $this->tuple->dot($this->tuple2);
        Assertion::same(true, Comparator::float($dotExcepted, $dot));
    }

    /**
     * @Then cross for a, b = vector(:vector)
     */
    public function crossForABVector(string $vector): void
    {
        $vectorCrossed = $this->tuple->cross($this->tuple2);
        $tupleArray = $this->stringToArrayFloat($vector);
        Assertion::same(true, Comparator::float($tupleArray[0], $vectorCrossed->getX()));
        Assertion::same(true, Comparator::float($tupleArray[1], $vectorCrossed->getY()));
        Assertion::same(true, Comparator::float($tupleArray[2], $vectorCrossed->getZ()));
    }

    /**
     * @Then cross for b, a = vector(:vector)
     */
    public function crossForBAVector(string $vector): void
    {
        $vectorCrossed = $this->tuple2->cross($this->tuple);
        $tupleArray = $this->stringToArrayFloat($vector);
        Assertion::same(true, Comparator::float($tupleArray[0], $vectorCrossed->getX()));
        Assertion::same(true, Comparator::float($tupleArray[1], $vectorCrossed->getY()));
        Assertion::same(true, Comparator::float($tupleArray[2], $vectorCrossed->getZ()));
    }

    /**
     * @Given c = color(:colors)
     * @Given c1 = color(:arg1)
     * @Given c2 = color(:arg1)
     */
    public function color(string $colors): void
    {
        $this->colors[] = new Color(...$this->stringToArray($colors));
    }

    /**
     * @Then c.red = :color
     */
    public function colorRedEqualTo(float $color): void
    {
        Assertion::eq($this->colors[0]->getRed(), $color);
    }

    /**
     * @Then c.green = :color
     */
    public function colorGreenEqualTo(float $color): void
    {
        Assertion::eq($this->colors[0]->getGreen(), $color);
    }

    /**
     * @Then c.blue = :color
     */
    public function colorBlueEqualTo(float $color): void
    {
        Assertion::eq($this->colors[0]->getBlue(), $color);
    }

    /**
     * @Then c1 + c2 = (:color)
     */
    public function addingColor(string $colorExcepted): void
    {
        $c1 = $this->colors[0];
        $c2 = $this->colors[1];

        $color = (new ColorCalculator())->adding($c1, $c2);
        $colorExcepted = $this->stringToArray($colorExcepted);

        Assertion::same(true, Comparator::float($colorExcepted[0], $color->getRed()));
        Assertion::same(true, Comparator::float($colorExcepted[1], $color->getGreen()));
        Assertion::same(true, Comparator::float($colorExcepted[2], $color->getBlue()));
    }

    /**
     * @Then c1 - c2 = (:color)
     */
    public function cC2(string $colorExcepted): void
    {
        $c1 = $this->colors[0];
        $c2 = $this->colors[1];

        $color = (new ColorCalculator())->substrating($c1, $c2);
        $colorExcepted = $this->stringToArray($colorExcepted);

        Assertion::same(true, Comparator::float($colorExcepted[0], $color->getRed()));
        Assertion::same(true, Comparator::float($colorExcepted[1], $color->getGreen()));
        Assertion::same(true, Comparator::float($colorExcepted[2], $color->getBlue()));
    }

    /**
     * @Then c * :coef = (:colorExcepted)
     */
    public function c(float $coef, string $colorExcepted): void
    {
        $c1 = $this->colors[0];

        $color = (new ColorCalculator())->multipliyingByCoef($c1, $coef);
        $colorExcepted = $this->stringToArray($colorExcepted);

        Assertion::same(true, Comparator::float($colorExcepted[0], $color->getRed()));
        Assertion::same(true, Comparator::float($colorExcepted[1], $color->getGreen()));
        Assertion::same(true, Comparator::float($colorExcepted[2], $color->getBlue()));
    }

    /**
     * @Then c1 * c2 = (:colorExcepted)
     */
    public function thenMultiplyColors(string $colorExcepted): void
    {
        $c1 = $this->colors[0];
        $c2 = $this->colors[1];

        $color = (new ColorCalculator())->multipliyingByColor($c1, $c2);
        $colorExcepted = $this->stringToArray($colorExcepted);

        Assertion::same(true, Comparator::float($colorExcepted[0], $color->getRed()));
        Assertion::same(true, Comparator::float($colorExcepted[1], $color->getGreen()));
        Assertion::same(true, Comparator::float($colorExcepted[2], $color->getBlue()));
    }

    /**
     * @When r <- reflect(:v, :n)
     */
    public function whenReflect(): void
    {
        $this->tuple = $this->tuple->reflect($this->tuple2);
    }
}
