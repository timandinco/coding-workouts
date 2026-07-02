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
      <h2>Solutions</h2>

      <div>
        <h4>PHP Code:</h4>
        <pre>
        $users = [
          ['name' => '  alice smith ', 'email' => 'ALICE@example.com', 'status' => 'active'],
          ['name' => 'bob JONES', 'email' => 'Bob@Repo.com', 'status' => 'inactive'],
          ['name' => '  cHarLie brown', 'email' => 'CHARLIE@BRwn.net', 'status' => 'active'],
        ];

        $filteredUsers = array_filter($users, function($user) {
            return $user['status'] === 'active';
        });

        $filteredUsers = array_map(function($user) {
            $user['name'] = ucwords(strtolower(trim($user['name'])));
            $user['email'] = strtolower($user['email']);
            return $user;
        }, $filteredUsers);     
        </pre>

        <h4>Optimized PHP Code:</h4>
        <pre>
          $filteredUsers = array_map(function($user) {
              if ($user['status'] !== 'active') {
                  return null;
              }
              return [
                  'name' => ucwords(strtolower(trim($user['name']))),
                  'email' => strtolower($user['email']),
                  'status' => $user['status']
              ];
          }, $users);

          $filteredUsers = array_values(array_filter($filteredUsers));
        </pre>

        <h4>Output:</h4>
        <?php
        $users = [
          ['name' => '  alice smith ', 'email' => 'ALICE@example.com', 'status' => 'active'],
          ['name' => 'bob JONES', 'email' => 'Bob@Repo.com', 'status' => 'inactive'],
          ['name' => '  cHarLie brown', 'email' => 'CHARLIE@BRwn.net', 'status' => 'active'],
        ];

        $filteredUsers = array_filter($users, function($user) {
            return $user['status'] === 'active';
        });

        $filteredUsers = array_map(function($user) {
            $user['name'] = ucwords(strtolower(trim($user['name'])));
            $user['email'] = strtolower($user['email']);
            return $user;
        }, $filteredUsers);        
        
        echo "<pre>";
        var_dump($users);
        var_export($filteredUsers);


        $cleanedUsers = array_map(function($user) {
              if ($user['status'] !== 'active') {
                  return null;
              }
              return [
                  'name' => ucwords(strtolower(trim($user['name']))),
                  'email' => strtolower($user['email']),
                  'status' => $user['status']
              ];
          }, $users);

        


        echo "<pre>";

        var_export($cleanedUsers);

        $cleanedUsers = array_values(array_filter($cleanedUsers));

        var_export($cleanedUsers);
        ?>

      </div>
    </section>
  </main>
</body>