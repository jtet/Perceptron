Perceptron
==========

##Training

    while($p->getIterationError() > $x)
    {
        for ($i = 0; $i < count($inputVectors); $i++){
            $p->train($inputVectors[$i]);
        }
    }

##Test an Input

echo $p->test($inputVector)? "True": "False";
