<?php
include("collatzConjectUtils.php");

// Single number Collatz sequence calculator
$collatzConjectureList = array();
$maxValue = NULL;
$userInput = NULL;

if (!empty($_POST["singleCollatzCalc"])) {
    $collatzConjectureList = collatzConjecture(htmlspecialchars($_POST["num"]));
    $userInput = $_POST["num"];
    $maxValue = highestNum($collatzConjectureList,$userInput);
}


// Range of number collatz sequence calculator
class Element
{
    private $number;
    private $maxValue;
    private $numIteration;
    public function __construct($number, $maxValue, $numIteration)
    {
        $this->number = $number;
        $this->maxValue = $maxValue;
        $this->numIteration = $numIteration;
    }
    public function getNumber()
    {
        return $this->number;
    }
    public function getMaxValue()
    {
        return $this->maxValue;
    }
    public function getIterations()
    {
        return $this->numIteration ;
    }
}

$collatzConjectureRangeList = array();
$elemHigh = NULL;
$elemLow = NULL;

if (!empty($_POST["rangeCollatzCalc"])) {
    $minRange = htmlspecialchars($_POST["minRange"]);
    $maxRange = htmlspecialchars($_POST["maxRange"]);

    for ($i = $minRange; $i <= $maxRange; $i++) {

        $collatzConjectBuff = collatzConjecture($i);
        $maxValueBuff = highestNum($collatzConjectBuff,$i);

        $elem = new Element($i, $maxValueBuff, count($collatzConjectBuff));
        array_push($collatzConjectureRangeList, $elem);

        if ($i == $minRange) {
            $elemHigh = $elem;
            $elemLow = $elem;
        }
        if ($elem->getIterations() > $elemHigh->getIterations())
            $elemHigh = $elem;
        if ($elem->getIterations() < $elemLow->getIterations())
            $elemLow = $elem;
    }
}
?>

<DOCTYPE html />
<html>

<head>
    <title>Collatz</title>
</head>

<style>
    header {
        width: fit-content;
        margin: 0px auto 0px auto;
    }

    header>h1 {
        display: flex;
        flex-direction: column;
        text-align: center;
    }

    header>h1>span {
        font-weight: lighter;
        font-size: 14px;
    }

    main {
        display: flex;
        column-gap: 20px;
        width: fit-content;
        margin: 50px auto 0px auto;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 300px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px gray;
        padding: 0px 10px 20px 10px;
        row-gap: 10px;
    }

    form>h1 {
        text-align: center;
    }

    form>label {
        display: flex;
        flex-direction: column;
        align-items: center;
        row-gap: 10px;
    }

    form>button {
        color: white;
        background-color: #228B22;
        padding: 10px 20px 10px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.5s;
    }

    form>button:hover {
        color: #228B22;
        background-color: #92E491;
    }

    .singleNumCollatzCalc>.result {
        display: flex;
        column-gap: 10px;
        max-width: 280px;
        margin: 10px auto 0px auto;
        overflow: auto;
        padding: 15px;
    }

    .singleNumCollatzCalc>.result>.num {
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px gray;

    }

    .rangeNumCollatzCalc>form>.range {
        display: flex;
        column-gap: 20px;
    }

    .rangeNumCollatzCalc>form>.range>label>input {
        width: 80px;

    }

    .rangeNumCollatzCalc>.result {
        padding: 10px;
        width: 350px;
        display: flex;
        flex-wrap: wrap;
        column-gap: 10px;
        row-gap: 16px;
        max-height: 250px;
        overflow-y: auto;
    }

    .rangeNumCollatzCalc>.result>.elem {
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px gray;
        display: flex;
        flex-direction: column;
    }

    .rangeNumCollatzCalc>.highestLowestNum {
        display: flex;
        column-gap: 20px;
        margin: 20px 0px 0px 0px;
        border: 1px solid gray;
        border-radius:10px;
        padding: 10px;
    }

    .rangeNumCollatzCalc>.highestLowestNum>.highestIteration,
    .lowestIteration {
        display: flex;
        flex-direction: column;
        padding:10px;
        border-radius: 10px;
        box-shadow: 0px 0px 10px gray;
    }
</style>

<body>
    <header>
        <h1>3x + 1 <span>Alex Bulganin</span></h1>
    </header>
    <main>
        <div class="singleNumCollatzCalc">
            <form class="CollatzForm"
                action="http://localhost:3000/OneDrive/Desktop/Second_semester/ObjectOrientedProgramming/taskOne/alexBulganinCollatzTask.php"
                method="POST">
                <h1>Collatz sequence calculation</h1>
                <label>
                    Enter a positive integer number:
                    <input type="number" name="num" min="1" required />
                </label>
                <input type="hidden" name="singleCollatzCalc" value="1" />
                <button>Calculate</button>
            </form>

            <div class="result">
                <?php if (count($collatzConjectureList) > 0) { ?>
                    <div class="num">
                        <?php echo $userInput; ?>
                    </div>
                    <?php foreach ($collatzConjectureList as $val) { ?>
                        <div class="num">
                            <?php echo $val; ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <?php if (count($collatzConjectureList) > 0) { ?>
                <p>
                    Number of Iterations:
                    <?php echo count($collatzConjectureList); ?>
                </p>
                <p>
                    Highest number from the iteration:
                    <?php echo $maxValue; ?>
                </p>
            <?php } ?>
        </div>

        <div class="rangeNumCollatzCalc">
            <form
                action="http://localhost:3000/OneDrive/Desktop/Second_semester/ObjectOrientedProgramming/taskOne/alexBulganinCollatzTask.php"
                method="POST">
                <h1>Collatz sequences between a range</h1>
                <div class="range">
                    <label>
                        <input type="number" name="minRange" placeholder="Min" required />
                    </label>
                    <label>
                        <input type="number" name="maxRange" placeholder="Max" required />
                    </label>
                </div>
                <input type="hidden" name="rangeCollatzCalc" value="1" />
                <button>Generate</button>
            </form>

            <div class="result">
                <?php if (count($collatzConjectureRangeList) > 0) { ?>
                    <?php foreach ($collatzConjectureRangeList as $elem) { ?>
                        <div class="elem">
                            <span class="number">
                                Number:
                                <?php echo $elem->getNumber(); ?>
                            </span>

                            <span class="interations">
                                Iterations:
                                <?php echo $elem->getIterations(); ?>
                            </span>

                            <span class="maxValue">
                                Highest Value:
                                <?php echo $elem->getMaxValue(); ?>
                            </span>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="highestLowestNum">
                <?php if (count($collatzConjectureRangeList) > 0) { ?>
                    <div class="highestIteration">
                        <span>
                            Number:<?php echo $elemHigh->getNumber() ?>
                        </span>
                        <span>
                            Iterations:<?php echo $elemHigh->getIterations() ?>
                        </span>
                        <span>
                            Highest Value:<?php echo $elemHigh->getMaxValue() ?>
                        </span>
                    </div>
                    <div class="lowestIteration">
                        <span>
                             Number:<?php echo $elemLow->getNumber() ?>
                        </span>
                        <span>
                            Iterations:<?php echo $elemLow->getIterations() ?>
                        </span>
                        <span>
                            Highest Value:<?php echo $elemLow->getMaxValue() ?>
                        </span>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

</body>

</html>