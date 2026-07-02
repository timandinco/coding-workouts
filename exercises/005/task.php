<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP</title>
</head>
<body>
<header>
    <h1>Exercise 005: The Inventory Auditor</h1>

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
          $inventory = [
          ["name" => "Keyboard", "price" => 50, "stock_count" => 10],
          ["name" => "Mouse", "price" => 25, "stock_count" => 0],
          ["name" => "Monitor", "price" => 200, "stock_count" => 5],
          ["name" => "Mousepad", "price" => 15, "stock_count" => 0],
          ["name" => "Laptop", "price" => 1000, "stock_count" => 2],
          ["name" => "Charger", "price" => 20, "stock_count" => 10],
          ["name" => "Webcam", "price" => 80, "stock_count" => 0],
          ["name" => "Headset", "price" => 120, "stock_count" => 3],
          ];

        $inStockProducts = array_filter($inventory, function($product) {
            return $product['stock_count'] > 0;
        });

        $inStock = array_filter($inventory, fn($product) => $product['stock_count'] > 0);

        $totalValue = array_reduce($inStockProducts, function($carry, $product) {
          return $carry + ($product['price'] * $product['stock_count']);
        }, 0);

        printf("In stock: %s. Total Value: \$%d", implode(", ", array_column($inStockProducts, 'name')), $totalValue);

        echo "<pre>";
        var_dump($inStockProducts);
        var_dump($inStock);
        var_dump($totalValue);

        ?>


      <?php
      $names = [];
      $total = 0;
      foreach ($inventory as $p) {
          if ($p['stock_count'] > 0) {
              $names[] = $p['name'];
              $total += $p['price'] * $p['stock_count'];
          }
      }
      printf("In stock: %s. Total Value: \$%d", implode(", ", $names), $total);
        ?>


    <?php
    $inStock = array_filter($inventory, fn($p) => $p['stock_count'] > 0);
    $names = implode(", ", array_column($inStock, 'name'));
    $total = array_sum(array_map(fn($p) => $p['price'] * $p['stock_count'], $inStock));
    echo "In stock: $names. Total Value: \$$total";

    ?>

    <?php
    $acc = array_reduce($inventory, function($carry, $p) {
        if ($p['stock_count'] <= 0) return $carry;
        $carry['names'][] = $p['name'];
        $carry['total'] += $p['price'] * $p['stock_count'];
        return $carry;
    }, ['names' => [], 'total' => 0]);

    printf("In stock: %s. Total Value: \$%d", implode(", ", $acc['names']), $acc['total']);

    ?>

    <?php
    $names = [];
    $total = 0;
    array_walk($inventory, function($p) use (&$names, &$total) {
        if ($p['stock_count'] > 0) {
            $names[] = $p['name'];
            $total += $p['price'] * $p['stock_count'];
        }
    });
    $output = sprintf("In stock: %s. Total Value: \$%d", implode(", ", $names), $total);
    echo $output;
    ?>

    <?php
      function inStockGenerator(array $inventory) {
          foreach ($inventory as $p) {
              if ($p['stock_count'] > 0) yield $p;
          }
      }

      $names = [];
      $total = 0;
      foreach (inStockGenerator($inventory) as $p) {
          $names[] = $p['name'];
          $total += $p['price'] * $p['stock_count'];
      }
      printf("In stock: %s. Total Value: \$%d", implode(", ", $names), $total);
      ?>
      </div>
    </section>

 
  </main>

  <footer>


  </footer>


</body>