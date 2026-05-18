<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP Associative Merge</title>
</head>
<body>
    <h4>3. The "Associative Merge"</h4>
    <p>You have two associative arrays representing user settings. Write a script to merge them. If a key exists in both, the value from the second array ($newSettings) should overwrite the first ($defaultSettings). Then, print the final array as a JSON string.</p>
    <ul>
        <li><strong>Inputs:</strong>
            <ul>
                <li>$defaultSettings = ['theme' => 'light', 'notifications' => true, 'lang' => 'en'];</li>
                <li>$newSettings = ['theme' => 'dark', 'lang' => 'fr'];</li>
            </ul>
        </li>
        <li><strong>Expected Output:</strong> {"theme":"dark","notifications":true,"lang":"fr"}</li>
    </ul>

    <h4>PHP Code:</h4>
    <pre>
     
        $defaultSettings = ['theme' => 'light', 'notifications' => true, 'lang' => 'en'];
        $newSettings = ['theme' => 'dark', 'lang' => 'fr'];

        // Merge the arrays, with $newSettings overwriting $defaultSettings
        $mergedSettings = array_merge($defaultSettings, $newSettings);

        // Output the result as JSON
        echo json_encode($mergedSettings);
   
    </pre>

    <h4>Output:</h4>
    <?php
    $defaultSettings = ['theme' => 'light', 'notifications' => true, 'lang' => 'en'];
    $newSettings = ['theme' => 'dark', 'lang' => 'fr'];

    // Merge the arrays, with $newSettings overwriting $defaultSettings
    $mergedSettings = array_merge($defaultSettings, $newSettings);

    // Output the result as JSON
    echo json_encode($mergedSettings);
    ?>
</body>
</html>