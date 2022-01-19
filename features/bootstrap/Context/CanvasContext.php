<?php

namespace RayTracer\Tests\Context;

use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use RayTracer\Canvas\Canvas;
use RayTracer\Color\Color;
use RayTracer\PortablePixmapMapper;
use RayTracer\Utils\Comparator;

/**
 * Defines application features from the specific context.
 */
class CanvasContext implements Context
{
    use ArrayHelperTrait;

    private Canvas $canvas;
    private array $colors;
    private string $ppmFileContent;

    /**
     * @Given c <- canvas(:canvas)
     */
    public function canvasAffectation($canvas)
    {
        $canvas = $this->stringToArrayFloat($canvas);
        $this->canvas = new Canvas(...$canvas);
    }

    /**
     * @Then c.width = :width
     */
    public function widthEquals(int $width)
    {
        Assertion::eq($width, $this->canvas->getWidth());
    }

    /**
     * @Then c.height = :height
     */
    public function heightEquals(int $height)
    {
        Assertion::eq($height, $this->canvas->getHeight());
    }

    /**
     * @Then every pixel of c is color(:color)
     */
    public function everyPixelOfCIsColor(string $color)
    {
        $colorExcepted = new Color(...$this->stringToArrayFloat($color));

        for ($x = 1; $x <= 10; ++$x) {
            for ($y = 1; $y <= 20; ++$y) {
                Assertion::same($this->canvas->pixelAt($x, $y)->__toString(), $colorExcepted->__toString());
            }
        }
    }

    /**
     * @Given :colorName <- color(:color)
     */
    public function redColor($colorName, $color)
    {
        $this->colors[$colorName] = new Color(...$this->stringToArrayFloat($color));
    }

    /**
     * @When write_pixel(c, :arg1, red)
     */
    public function writePixelCRed($arg1)
    {
        [$x, $y] = $this->stringToArrayFloat($arg1);
        $this->canvas->writePixel($x, $y, $this->colors[0]);
    }

    /**
     * @Then pixel_at(c, :arg1) = red
     */
    public function pixelAtCRed($arg1)
    {
        [$x, $y] = $this->stringToArrayFloat($arg1);
        Assertion::same($this->canvas->pixelAt($x, $y)->__toString(), $this->colors['red']->__toString());
    }

    /**
     * @When ppm <- canvas_to_ppm
     */
    public function ppmCanvasToPpmC()
    {
        $this->ppmFileContent = (new PortablePixmapMapper())->map($this->canvas);
    }

    /**
     * @Then the file header has :
     */
    public function theFileHeaderHas(PyStringNode $headerExcepted)
    {
        Assertion::contains($this->ppmFileContent, $headerExcepted->getRaw());
    }

    /**
     * @When write_pixel(:arg1)
     */
    public function writePixel($arg1)
    {
        [$canvasName, $x, $y, $colorName] = $this->stringToArray($arg1);
        $this->canvas->writePixel($x, $y, $this->colors[$colorName]);
    }

    /**
     * @Then line :lines of ppm are :
     */
    public function lineOfPpmAre($lines, PyStringNode $content)
    {
        Assertion::same(true, Comparator::string($content->getRaw(), $this->ppmFileContent));
    }

    /**
     * @When every pixel of c is set to color(:arg1)
     */
    public function everyPixelOfCIsSetToColor($arg1)
    {
        $color = new Color(...$this->stringToArrayFloat($arg1));
        $this->canvas->initializePixels($color);
    }
}
