<?php

$quotes = [
    [
        'text' => 'An investment in knowledge pays the best interest.',
        'author' => 'Benjamin Franklin'
    ],
    [
        'text' => 'Quality is not an act, it is a habit.',
        'author' => 'Aristotle'
    ],
    [
        'text' => 'Make it work, make it right, make it fast—in that order.',
        'author' => 'Kent Beck'
    ],
    [
        'text' => 'Premature optimization is the root of all evil.',
        'author' => 'Donald Knuth'
    ],
    [
        'text' => 'Don\'t compare your beginning to someone else\'s middle.',
        'author' => 'Jon Acuff'
    ],
];

// Get a random quote based on the day
$dayOfYear = date('z');
$quote = $quotes[$dayOfYear % count($quotes)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PHP</title>
</head>
<body>  


<header>
  <h1>Coding Workout Hub</h1>
  <p>Welcome to the Coding Workout Hub! 
    Here, you'll find a variety of coding exercises designed to help you practice and improve 
    your programming skills. These are quick simple exercises to keep your coding muscles sharp. 
    Let's get coding!
  </p>
  <blockquote>
    <p>"<?php echo $quote['text']; ?>"</p>
    <footer>— <?php echo $quote['author']; ?></footer>
  </blockquote>
</header>
<main>
  <section>
    <h2>How to Use This Hub</h2>
    <div>
      Prompt Template:
      <div id="prompt-template">
        <pre>
      Good morning! It's [Day of Week], my [Language] practice day.  
      Please give me a quick, self-contained [Language] challenge that:  
        1. Can be attempted in 20-25 minutes without external resources.  
        2. Tests common everyday skills (e.g. [insert one or two examples from categories above]).  
        3. Includes a clear task description and any input/output requirements.  
        4. If it goes over time, suggest up to two specific topics or docs I should consult afterwards.  

      After I attempt it, I'll spend up to 15 more minutes researching any gaps, then write a 5-minute summary of my solution, learnings, and resources used.”
        </pre>
      </div>
    </div>
  </section>
  <section>
    <h2>Exercises</h2>
    <p>Click on the links below to access the exercises:</p>
    <div>
      <?php
      // Scans the exercises folder and creates links to each task
      $dirs = array_filter(glob('exercises/*'), 'is_dir');
      foreach ($dirs as $dir) {
          echo "<ul><li><a href='$dir'>$dir HTML/CSS/JavaScript</a></li>";
          echo "<li><a href='$dir/task.php'>$dir PHP</a></li></ul>";
      }
      ?>
    </div>
  </section>
</main>
<footer>
  <p>&copy; <?php echo date('Y'); ?> Coding Workout Hub. All rights reserved.</p>
</footer>
</body>
</html>