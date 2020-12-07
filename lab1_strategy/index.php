<?php
class Context
{
    private $algoritm;

    public function __construct(Algoritm $algoritm)
    {
        $this->algoritm = $algoritm;
    }

    public function setStrategy(Algoritm $algoritm)
    {
        $this->algoritm = $algoritm;
    }

    public function sort(): void
    {
        $result = $this->algoritm->doAlgorithm([55, 4, 3, 2, 1, 11, 23]);
        echo implode(",", $result) . "\n";

    }
}

interface Algoritm
{
    public function doAlgorithm(array $data): array;
}

class Bubble implements Algoritm
{
    public function doAlgorithm(array $data): array
    {
        echo "Bubble sort \n";

        for ($i = 0; $i < count($data); $i++){
            for ($j = $i + 1; $j < count($data); $j++) {
                if ($data[$i] > $data[$j]) {
                    $temp = $data[$j];
                    $data[$j] = $data[$i];
                    $data[$i] = $temp;
                }
            }
        }

        return $data;
    }
}

class Inserts implements Algoritm
{
    public function doAlgorithm(array $data): array
    {
        echo "Inserts sort \n";

        for ($i = 1; $i < count($data); $i++) {
            $x = $data[$i];
            for ($j = $i - 1; $j >= 0 && $data[$j] > $x; $j--) {
                $data[$j + 1] = $data[$j];
            }
            $data[$j + 1] = $x;
        }

        return $data;
    }
}

$context = new Context(new Bubble());
$context->sort();

echo "\n";

$context->setStrategy(new Inserts());
$context->sort();
