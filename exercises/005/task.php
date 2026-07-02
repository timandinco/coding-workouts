<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP</title>
</head>
<body>
<header>
    <h1>Exercise 005: PHP (The Inventory Auditor)</h1>

    <section id="description">
      <div id="focus">
        <strong>Focus: Associative arrays, filtering, and basic arithmetic.</strong> 
        <p>
        </p>
      </div>
      <div id="task">
        <strong>The Task:</strong>
        <p>
          You have an array of products. Each product is an associative array with a name, price, and stock_count.
        </p>
        <ol>
          <li>Filter out any products that have a stock_count of 0.</li>
          <li>Calculate the total value of the remaining inventory (Price × Stock).</li>
          <li>Output a single string: "In stock: [Product Names separated by commas]. Total Value: $[Total]."</li>
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
          $inventory = [
              ["name" => "Keyboard", "price" => 50, "stock_count" => 10],
              ["name" => "Mouse", "price" => 25, "stock_count" => 0],
              ["name" => "Monitor", "price" => 200, "stock_count" => 5],
              ["name" => "Mousepad", "price" => 15, "stock_count" => 0],
          ];
        </pre>
      </div>

      <div id="output">
        <h3>Output:</h3>
        <p id="output-value">
          <pre>In stock: Keyboard, Monitor. Total Value: \$1500</pre>
        </p>
      </div>
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