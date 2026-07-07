<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP</title>
</head>
<body>
<header>
    <h1>Exercise 005: </h1>

    <section id="description">
      <div id="focus">
        <strong>Focus: Associative arrays and conditional grouping.</strong> 
        <p>
        </p>
      </div>
      <div id="task">
        <strong>The Task:</strong>
        <p>
          You have a list of grocery items, each with a name, category, and price.
        </p>
  
        <ol>
          <li>Create a new associative array where the keys are the category names.</li>
          <li>The values should be the total cost of all items in that category.</li>
          <li>Round the final totals to 2 decimal places.</li>

        </ol>
      </div>
    </section>
  </header>
  <main>
    <section>
      <h2>Examples</h2>
      <div id="data">
        <h3>Input:</h3>
        <pre>
          $items = [
              ['name' => 'Apple',  'category' => 'Fruit', 'price' => 1.50],
              ['name' => 'Carrot', 'category' => 'Veg',   'price' => 0.80],
              ['name' => 'Banana', 'category' => 'Fruit', 'price' => 1.20],
              ['name' => 'Broccoli','category' => 'Veg',   'price' => 1.10],
              ['name' => 'Steak',  'category' => 'Meat',  'price' => 15.00]
          ];
        </pre>
      </div>

      <div id="output">
        <h3>Output:</h3>
        <p id="output-value">
          <pre>["Fruit" => 2.70, "Veg" => 1.90, "Meat" => 15.00]

</pre>
        </p>
      </div>
    </section>
    <section>
    <h4>Hints</h4>

    PHP: Look up array_key_exists() vs. the null coalescing operator (??) for initializing array keys.
JavaScript: Check the Set object (the fastest way to remove duplicates) and Array.prototype.sort().
</section>
    <section>
      <h2>Solutions</h2>

      <div>
        <h4>PHP Code:</h4>
        <pre>

        </pre>

        <h4>Output:</h4>
        <?php
        
        ?>

      </div>
    </section>

 
  </main>

  <footer>


  </footer>


</body>