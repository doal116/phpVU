<?php
include("./collatzConjecture.php");
$range = null;
$fib = false;

if (!empty($_POST["from"]))
    $range = new CollatzConjectureRange($_POST["from"], $_POST["to"]);
if (!empty($_POST["fibonacci"]))
    $fib = true;
?>

<html>

<head>

</head>
<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    h1>span {
        font-weight: lighter;
        font-size: 14px;
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    form {
        width: 300px;
        padding: 20px;
        display: flex;
        border-radius: 10px;
        flex-direction: column;
        row-gap: 10px;
        box-shadow: 0px 0px 10px gray;
    }

    form>label {
        row-gap: 10px;
        display: flex;
        flex-direction: column;
    }

    form>.fibCheckBox {
        display: flex;
        flex-direction: row;
    }

    form>label>input {
        outline: none;
        padding: 10px;
        border: 1px solid gray;
    }

    form>button {
        padding: 10px 0px 10px 0px;
        color: white;
        background-color: green;
        border: none;
        border-radius: 10px;
    }

    .resultRange {
        width: 300px;
        max-height: 300px;
        display: flex;
        flex-wrap: wrap;
        row-gap: 10px;
        column-gap: 10px;
        overflow-y: auto;
        padding: 10px;
    }

    .resultRange>.elem {
        display: flex;
        height: fit-content;
        flex-direction: column;
        row-gap: 10px;
        border-radius: 10px;
        padding: 8px;
        box-shadow: 0px 0px 10px gray;
    }

    .result {
        display: flex;
        flex-direction: column;
        row-gap: 16px;
    }

    .result>.conjecture {
        width: 280px;
        display: flex;
        column-gap: 10px;
        overflow-x: auto;
        padding: 10px;
    }

    .result>.conjecture>span {
        border-radius: 10px;
        padding: 8px;
        box-shadow: 0px 0px 10px gray;
    }

    .maxMin {
        padding: 10px;
        border-radius: 10px;
        border: 1px solid gray;
        display: flex;
        column-gap: 10px;
    }

    .maxMin>.elem {
        display: flex;
        height: fit-content;
        flex-direction: column;
        row-gap: 10px;
        border-radius: 10px;
        padding: 8px;
        box-shadow: 0px 0px 10px gray;
    }
</style>

<body>
    <h2>
        3x + 1 <span>Alex Bulganin</span>
    </h2>
    <form action="http://localhost:2000/mainFile.php" method="POST">
        <label>
            <input placeholder="Starting Number" name="from" type="number" min="2" required />
        </label>
        <label>
            Leave field bellow empty if you only need the sequence of one number.
            <input placeholder="Ending number(optional)" name="to" type="number" min="2" />
        </label>
        <span>If you wish you can get the result through the fibanocci sequence: </span>
        <label class="fibCheckBox">
            <input type="checkbox" name="fibonacci" value="true" />
            <span><strong>Fibonacci Sequence</strong> (optional)</span>
        </label>
        <button>Calculate</button>
    </form>


    <?php if ($range) { ?>
        <div class="resultRange">
            <?php
            if (count($range->getResults()) > 1) {
                foreach ($fib ? $range->get_fibonacciProgression() : $range->getResults() as $elem) { ?>
                    <div class="elem">
                        <span>Number:
                            <?php echo $elem->get_num() ?>
                        </span>
                        <span>Iterations:
                            <?php echo $elem->get_iterations() ?>
                        </span>
                        <span>Highest Value:
                            <?php echo $elem->get_highIteration() ?>
                        </span>
                    </div>
                <?php } ?>

            <?php } else {
                $oneConjecture = $range->getResults()[0]; ?>
                <div class="result">
                    <div class="conjecture">
                        <?php foreach ($oneConjecture->get_sequence() as $elem) { ?>
                            <span>
                                <?php echo $elem; ?>
                            </span>
                        <?php } ?>
                    </div>
                    <span>
                        Iterations:
                        <?php echo $oneConjecture->get_iterations(); ?>
                    </span>
                    <span>
                        Highest Value:
                        <?php echo $oneConjecture->get_highIteration(); ?>
                    </span>
                </div>
            <?php } ?>
        </div>
        <?php if (count($range->getResults()) > 1) { ?>
            <span>Min & Max value</span>
            <div class="maxMin">
                <?php
                foreach ($fib ? $range->get_Max_Min($range->get_fibonacciProgression()) : $range->get_Max_Min($range->getResults()) as $elem) { ?>
                    <div class="elem">
                        <span>Number:
                            <?php echo $elem->get_num() ?>
                        </span>
                        <span>Iterations:
                            <?php echo $elem->get_iterations() ?>
                        </span>
                        <span>Highest Value:
                            <?php echo $elem->get_highIteration() ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    <?php } ?>

</body>

</html>