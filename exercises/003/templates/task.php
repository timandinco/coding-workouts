<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP</title>
</head>
<body>
<header>
    <h1>Exercise 003: Order Summary</h1>

    <section id="description">
      <div id="focus">
        <strong>Focus: associative arrays, loops/array functions, filtering, totals</strong> 
        <p>
        </p>
      </div>
      <div id="task">
        <strong>The Task:</strong>

        <p>You are given a list of orders. Each order has:</p>
        <ul>
          <li>customer</li>
          <li>total</li>
          <li>status</li>
        </ul>
        

        <p>
        Write PHP code that:
        </p>
  
        <ol>
          <li>Keeps only orders with status "paid".</li>
          <li>Calculates the sum of all paid order totals.</li>
          <li>Creates an array of the paid customers' names.</li>

        </ol>

        <h4>Output Requirements</h4>
<p>Customer names should appear in the same order as the input.</p>
<p>Total should be displayed as:</p>
<pre>
  245.75
</pre>
      </div>
    </section>
  </header>
  <main>
    <section>
      <h2>Examples</h2>
      <div id="data">
        <h3>Input:</h3>
        <pre>
$orders = [
    ["customer" => "Alice", "total" => 120.50, "status" => "paid"],
    ["customer" => "Bob", "total" => 75.00, "status" => "pending"],
    ["customer" => "Carla", "total" => 45.25, "status" => "paid"],
    ["customer" => "Dan", "total" => 80.00, "status" => "paid"],
];
        </pre>
      </div>

      <div id="output">
        <h3>Output:</h3>
        <p id="output-value">
          <pre>Paid customers: Alice, Carla, Dan
Total paid: 245.75</pre>
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