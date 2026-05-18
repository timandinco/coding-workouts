
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

<div class="hero-section">
  <h1>Coding Workout Hub</h1>
  <blockquote>
    <p>"<?php echo $quote['text']; ?>"</p>
    <footer>— <?php echo $quote['author']; ?></footer>
  </blockquote>
</div>


<ul>
<?php
// Scans the exercises folder and creates links to each task
$dirs = array_filter(glob('exercises/*'), 'is_dir');
foreach ($dirs as $dir) {
    echo "<li><a href='$dir'>$dir</a></li>";
}
?>
</ul>