<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP</title>
</head>
<body>
    <h4>3. The "Score Averager"</h4>
    <p>
You have an array of student scores. Use array_filter() to remove any scores below 50, then use array_sum() 
and count() to calculate the average of the remaining scores.
    </p>
<ul>
<li><strong>Input:</strong> [45, 88, 92, 30, 75, 60]</li>
<li><strong>Expected Output:</strong> 78.75 <em>(Calculation: 88+92+75+60 = 315 / 4 = 78.75)</em></li>
</ul>


    <h4>PHP Code:</h4>
    <pre>
    $scores = [45, 88, 92, 30, 75, 60];
    $filteredScores = array_filter($scores, function($score) {
        return $score >= 50;
    });
    $average = array_sum($filteredScores) / count($filteredScores);
    echo $average;
    </pre>

    <h4>Output:</h4>
    <?php
    $scores = [45, 88, 92, 30, 75, 60];
    $filteredScores = array_filter($scores, function($score) {
        return $score >= 50;
    });
    $average = array_sum($filteredScores) / count($filteredScores);
    echo $average;
    ?>

</body>