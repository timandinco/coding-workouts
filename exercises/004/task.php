<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP</title>
</head>
<body>
<header>
    <h1>Exercise 004: The User Data Sanitizer </h1>

    <p>
      <strong>Focus:</strong> Array manipulation, string formatting, and filtering.
      </p>  
     
  </header>
  <main>
    <section>
      <strong>The Task:</strong>
      You have received a "dirty" array of user data from a legacy form. You need to:
      <ul>
      <li>Filter: Remove any users who are marked as inactive.</li>
      <li>Sanitize: Trim whitespace from names and ensure all emails are lowercase.</li>
      <li>Transform: Change the name format to "Title Case" (e.g., "jOHN dOE" becomes "John Doe").</li>
      </ul>
      <strong>Output:</strong>
      A clean array containing only Alice and Charlie, with names trimmed/capitalized and emails lowercased.
    </section>
    <section>
      <h2>Input</h2>
      <pre>
        $users = [
          ['name' => '  alice smith ', 'email' => 'ALICE@example.com', 'status' => 'active'],
          ['name' => 'bob JONES', 'email' => 'Bob@Repo.com', 'status' => 'inactive'],
          ['name' => '  cHarLie brown', 'email' => 'CHARLIE@BRwn.net', 'status' => 'active'],
        ];
      </pre>
    </section>

    <section>

      <h4>PHP Code:</h4>
      <pre>

      </pre>

      
      <?php
        $users = [
          ['name' => '  alice smith ', 'email' => 'ALICE@example.com', 'status' => 'active'],
          ['name' => 'bob JONES', 'email' => 'Bob@Repo.com', 'status' => 'inactive'],
          ['name' => '  cHarLie brown', 'email' => 'CHARLIE@BRwn.net', 'status' => 'active'],
        ];

      ?>
    </section>
    <section>
      <h4>Output:</h4>
    </section>
  </main>
</body>