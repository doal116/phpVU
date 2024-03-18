<?php
include("./collatzConjecture.php");
$range = null;
$fib = false;
$hist = false;
$histogram = null;

if (!empty($_POST["from"])) {
    $range = new CollatzConjectureRange($_POST["from"], $_POST["to"]);

}
if (!empty($_POST["fibonacci"]))
    $fib = true;

if (!empty($_POST["diagram"]) && !empty($_POST["to"])) {
    $hist = true;
    $histogram = new Diagram($_POST["from"], $_POST["to"]);
}
?>


<html>

<head>
    <script src="https://d3js.org/d3.v7.min.js"></script>
</head>
<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .resultSec {
        display: flex;
    }

    .maxMinSec {
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

    form>.histoCheckBox {
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

    #myHistogram {
        box-shadow: 0px 0px 10px gray;
    }

    .rectSt {
        fill: rgb(100, 118, 118);
    }

    .rectSt:hover {
        fill: rgb(64, 224, 208);
        cursor: pointer;
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
        <label class="histoCheckBox">
            <input type="checkbox" name="diagram" value="true" />
            <span><strong>Histogram</strong> (optional)</span>
        </label>
        <button>Calculate</button>
    </form>
    <div class="resultSec">
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
                <div classs="maxMinSec">
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
                </div>
            <?php } ?>
            <?php if ($hist) { ?>

                <svg id="myHistogram"></svg>

                <script>
                    const xAxisd = <?php echo $histogram->getXAxis(); ?>;
                    const yAxisd = <?php echo $histogram->getYAxis(); ?>;
                    const dataset = [];
                    xAxisd.forEach((elem, i) => dataset.push([parseInt(xAxisd[i]), parseInt(yAxisd[i])]));

                    const height = 300;
                    const width = 500;
                    const padding = 30;

                    const xScale = d3.scaleLinear()
                        .domain([d3.min(dataset, (d) => d[0]), d3.max(dataset, (d) => d[0]) + 1])
                        .range([padding, width - padding]);

                    const yScale = d3.scaleLinear()
                        .domain([0, d3.max(dataset, (d) => d[1])])
                        .range([height - padding, padding]);

                    const svg = d3.select("#myHistogram")
                        .attr("height", height)
                        .attr("width", width);

                    svg.selectAll("rect")
                        .data(dataset)
                        .enter()
                        .append("rect")
                        .attr("class", "rectSt")
                        .attr("height", (d) => height - yScale(d[1]) - padding)
                        .attr("width", (d) => (width - 2 * padding) / dataset.length)
                        .attr("x", (d, i) => xScale(d[0]))
                        .attr("y", (d) => yScale(d[1]))
                        .append("title")
                        .text((d) => `Number: ${d[0]} \nIterations: ${d[1]}`);

                    const yAxis = d3.axisLeft(yScale);
                    const xAxis = d3.axisBottom(xScale);
                    svg.append("g")
                        .attr("transform", `translate(${padding},${0})`)
                        .call(yAxis);
                    svg.append("g")
                        .attr("transform", `translate(${0},${height - padding})`)
                        .call(xAxis);

                </script>

            <?php } ?>
        <?php } ?>
    </div>
    <script>
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                checkboxes.forEach(otherCheckbox => {
                    if (otherCheckbox !== this) {
                        otherCheckbox.checked = false;
                    }
                });
            });
        });
    </script>
</body>

</html>