<?php

declare(strict_types=1);

namespace RayTracer\Math;

use Behat\Gherkin\Node\TableNode;
use RayTracer\Model\Tuple;
use RayTracer\Model\TupleInterface;
use RayTracer\Utils\Comparator;
use RuntimeException;

class Matrix
{
    /**
     * @var array<int, array<float>>
     */
    private array $elements;

    /**
     * @param array<int, array<float>> $elements
     */
    public function __construct(array $elements)
    {
        $this->elements = $elements;
    }

    public function element(int $x, int $y): float
    {
        return $this->elements[$x][$y];
    }

    public function size(): int
    {
        return count($this->elements);
    }

    public function multiply(self $that): self
    {
        $size = $this->size();
        $result = [];

        foreach (range(0, $size - 1) as $i) {
            foreach (range(0, $size - 1) as $j) {
                $result[$i][$j] = 0.0;
            }
        }

        foreach (range(0, $size - 1) as $i) {
            foreach (range(0, $size - 1) as $k) {
                foreach (range(0, $size - 1) as $j) {
                    $result[$i][$k] += $this->elements[$i][$j] * $that->element($j, $k);
                }
            }
        }

        return new self($result);
    }

    public function multiplyByTuple(TupleInterface $tuple): TupleInterface
    {
        if (4 !== $this->size()) {
            throw new RuntimeException('Multiplication of matrix and tuple is only implemented for 4x4 matrices');
        }

        $result = [0.0, 0.0, 0.0, 0.0];

        foreach (range(0, 3) as $i) {
            $result[$i] += $this->elements[$i][0] * $tuple->getX();
            $result[$i] += $this->elements[$i][1] * $tuple->getY();
            $result[$i] += $this->elements[$i][2] * $tuple->getZ();
            $result[$i] += $this->elements[$i][3] * $tuple->getW();
        }

        return Tuple::from(...$result);
    }

    public static function identify(int $size): self
    {
        $elements = [];
        foreach (range(0, $size - 1) as $i) {
            foreach (range(0, $size - 1) as $j) {
                $elements[$i][$j] = ($i === $j) ? 1.0 : 0.0;
            }
        }

        return new self($elements);
    }

    /**
     * @phpstan-ignore-next-line
     */
    public static function fromTableNode(TableNode $matrix): self
    {
        $elements = [];
        foreach ($matrix as $rowKey => $row) {
            foreach ($row as $columnKey => $element) {
                $elements[(int) $rowKey][(int) $columnKey] = floatval($element);
            }
        }

        return new self($elements);
    }

    /**
     * @param array<int, array<float>> $elements
     */
    public static function fromArray(array $elements): self
    {
        return new self($elements);
    }

    public function equalTo(self $that): bool
    {
        $size = $this->size();
        if ($size !== $that->size()) {
            return false;
        }

        foreach (range(0, $size - 1) as $i) {
            foreach (range(0, $size - 1) as $j) {
                if (false === Comparator::float($this->elements[$i][$j], $that->element($i, $j))) {
                    return false;
                }
            }
        }

        return true;
    }

    public function transpose(): self
    {
        $elements = [];
        $size = $this->size();

        foreach (range(0, $size - 1) as $i) {
            foreach (range(0, $size - 1) as $j) {
                $elements[$i][$j] = $this->elements[$j][$i];
            }
        }

        return new self($elements);
    }

    public function inverse(): self
    {
        if (false === $this->invertible()) {
            throw new RuntimeException('For inverse matrix need to invertible.');
        }

        $elements = [];
        $size = $this->size();
        $determinant = $this->determinant();

        foreach (range(0, $size - 1) as $i) {
            foreach (range(0, $size - 1) as $j) {
                $cofactor = $this->cofactor($i, $j);

                $elements[$j][$i] = $cofactor / $determinant;
            }
        }

        return new self($elements);
    }

    public function invertible(): bool
    {
        return 0.0 !== $this->determinant();
    }

    public function determinant(): float
    {
        $size = $this->size();

        if (2 === $size) {
            return $this->elements[0][0] * $this->elements[1][1] -
                   $this->elements[0][1] * $this->elements[1][0];
        }

        $determinant = 0.0;

        foreach (range(0, $size - 1) as $i) {
            $determinant += $this->cofactor(0, $i) * $this->elements[0][$i];
        }

        return $determinant;
    }

    public function submatrix(int $row, int $column): self
    {
        $size = $this->size();
        $elements = [];
        $tmp = [];

        foreach (range(0, $size - 1) as $i) {
            if ($i === $row) {
                continue;
            }

            foreach (range(0, $size - 1) as $j) {
                if ($j === $column) {
                    continue;
                }
                $tmp[$i][$j] = $this->elements[$i][$j];
            }
        }

        foreach (array_keys($tmp) as $key) {
            $elements[] = array_values($tmp[$key]);
        }

        return new self($elements);
    }

    public function minor(int $row, int $column): float
    {
        return $this->submatrix($row, $column)->determinant();
    }

    public function cofactor(int $row, int $column): float
    {
        $minor = $this->minor($row, $column);

        if (($row + $column) % 2 !== 0) {
            $minor *= -1.0;
        }

        return $minor;
    }
}
