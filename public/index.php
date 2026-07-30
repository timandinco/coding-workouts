<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/exercises.php';
require_once __DIR__ . '/../src/challenges.php';
require_once __DIR__ . '/../src/views/layout.php';

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$uri = '/' . trim($uri, '/');
$method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

function renderHomePage(): void
{
    $quotes = [
        ['text' => 'An investment in knowledge pays the best interest.', 'author' => 'Benjamin Franklin'],
        ['text' => 'Quality is not an act, it is a habit.', 'author' => 'Aristotle'],
        ['text' => 'Make it work, make it right, make it fast—in that order.', 'author' => 'Kent Beck'],
        ['text' => 'A strong mind is a practiced mind.', 'author' => 'Antigravity'],
    ];

    $dayOfYear = (int) date('z');
    $quote = $quotes[$dayOfYear % count($quotes)];

    $exercises = getExerciseCatalog();
    $listItems = '';

    foreach ($exercises as $exercise) {
        $href = htmlspecialchars(buildExerciseHref($exercise['id']), ENT_QUOTES, 'UTF-8');
        $title = htmlspecialchars($exercise['title'], ENT_QUOTES, 'UTF-8');
        $summary = htmlspecialchars($exercise['summary'], ENT_QUOTES, 'UTF-8');
        $focus = htmlspecialchars($exercise['focus'], ENT_QUOTES, 'UTF-8');

        $listItems .= sprintf(
            '<li>
                <h3><a href="%s">%s</a></h3>
                <p class="summary">%s</p>
                <div class="meta-tag"><strong>Focus:</strong> %s</div>
            </li>',
            $href,
            $title,
            $summary,
            $focus
        );
    }

    $body = <<<HTML
<section class="welcome-section">
    <h2>Welcome to the PHP Practice Field</h2>
    <p>Practice PHP array, string, and math manipulations here. Solve challenges from memory without docs to build deep code chops!</p>
    <div class="quote">
        <p>“{$quote['text']}”</p>
        <footer>— {$quote['author']}</footer>
    </div>
</section>

<section>
    <h2>Workouts</h2>
    <ul class="exercise-list">{$listItems}</ul>
</section>
HTML;

    echo renderLayout('PHP Coding Workout Hub', $body);
}

function renderExercisePage(string $id): void
{
    $exercise = getExerciseById($id);
    if ($exercise === null) {
        header('HTTP/1.1 404 Not Found');
        echo renderLayout('Exercise not found', '<p>The requested exercise could not be found.</p>');
        return;
    }

    $challenge = getChallengeById($id);
    if ($challenge === null) {
        header('HTTP/1.1 404 Not Found');
        echo renderLayout('Exercise not found', '<p>The requested exercise could not be found.</p>');
        return;
    }

    $escapedTitle = htmlspecialchars($challenge['title'], ENT_QUOTES, 'UTF-8');
    $escapedFocus = htmlspecialchars($challenge['focus'], ENT_QUOTES, 'UTF-8');
    $escapedDescription = nl2br(htmlspecialchars($challenge['description'], ENT_QUOTES, 'UTF-8'), false);
    $escapedStarter = htmlspecialchars($challenge['starter_code'], ENT_QUOTES, 'UTF-8');
    $escapedExpected = htmlspecialchars($challenge['expected_output'], ENT_QUOTES, 'UTF-8');
    $runUrl = '/challenges/' . $challenge['slug'] . '/run';

    $body = <<<HTML
<p class="back-link"><a href="/">&larr; Back to the hub</a></p>

<div class="split-pane">
    <!-- Left Pane: Challenge Docs -->
    <div class="doc-pane">
        <h1>{$escapedTitle}</h1>
        <div class="meta-tag"><strong>Focus:</strong> {$escapedFocus}</div>
        
        <div class="instructions">
            <h3>Instructions</h3>
            <p>{$escapedDescription}</p>
        </div>
        
        <div class="expected-block">
            <h3>Expected Output</h3>
            <pre><code>{$escapedExpected}</code></pre>
        </div>
    </div>
    
    <!-- Right Pane: Code Runner & Console -->
    <div class="runner-pane">
        <form id="runner-form" method="post" action="{$runUrl}">
            <div class="editor-header">
                <h3>Code Editor</h3>
                <span class="editor-label">PHP (omit &lt;?php)</span>
            </div>
            
            <textarea id="code-textarea" name="code" rows="14" spellcheck="false" placeholder="// Write your PHP code here...">{$escapedStarter}</textarea>
            
            <div class="action-bar">
                <button type="button" id="reset-btn" class="secondary-btn">Reset</button>
                <button type="submit" id="run-btn" class="primary-btn">Run & Test (Ctrl+Enter)</button>
            </div>
        </form>
        
        <div class="console-box" id="result-console">
            <div class="console-header">
                <h3>Test Results</h3>
                <span id="status-badge" class="badge badge-idle">Ready</span>
            </div>
            <div class="console-body">
                <div id="assertion-feedback" class="feedback-clause hidden">
                    <span class="feedback-title">Result:</span>
                    <span id="feedback-text"></span>
                </div>
                <div class="output-wrapper">
                    <span>Console Output:</span>
                    <pre><code id="stdout-pre">Click Run & Test to execute your solution.</code></pre>
                </div>
                <div id="error-wrapper" class="output-wrapper error-wrapper hidden">
                    <span>Errors / Exceptions:</span>
                    <pre><code id="stderr-pre"></code></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('runner-form');
    const textarea = document.getElementById('code-textarea');
    const resetBtn = document.getElementById('reset-btn');
    const runBtn = document.getElementById('run-btn');
    const statusBadge = document.getElementById('status-badge');
    const feedbackClause = document.getElementById('assertion-feedback');
    const feedbackText = document.getElementById('feedback-text');
    const stdoutPre = document.getElementById('stdout-pre');
    const errorWrapper = document.getElementById('error-wrapper');
    const stderrPre = document.getElementById('stderr-pre');
    
    const defaultCode = `{$escapedStarter}`;

    // Enable soft tabs (spaces) in textarea
    textarea.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            e.preventDefault();
            const start = textarea.selectionStart;
            const end = textarea.selectionEnd;
            textarea.value = textarea.value.substring(0, start) + "    " + textarea.value.substring(end);
            textarea.selectionStart = textarea.selectionEnd = start + 4;
        }
        
        // Ctrl + Enter shortcut
        if (e.key === 'Enter' && e.ctrlKey) {
            e.preventDefault();
            form.requestSubmit();
        }
    });
    
    resetBtn.addEventListener('click', () => {
        if (confirm('Are you sure you want to reset the editor to the starter code?')) {
            textarea.value = defaultCode;
            statusBadge.className = 'badge badge-idle';
            statusBadge.textContent = 'Ready';
            feedbackClause.classList.add('hidden');
            stdoutPre.textContent = 'Click Run & Test to execute your solution.';
            errorWrapper.classList.add('hidden');
            stderrPre.textContent = '';
        }
    });
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        runBtn.disabled = true;
        runBtn.textContent = 'Executing...';
        statusBadge.className = 'badge badge-running';
        statusBadge.textContent = 'Running...';
        
        const formData = new FormData(form);
        formData.append('ajax', '1');
        
        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            
            if (!response.ok) {
                throw new Error('HTTP failure: ' + response.status);
            }
            
            const result = await response.json();
            
            // Console output
            stdoutPre.textContent = result.output !== '' ? result.output : '(No output printed)';
            
            // Handle error wrapper
            if (result.error) {
                errorWrapper.classList.remove('hidden');
                stderrPre.textContent = result.error;
            } else {
                errorWrapper.classList.add('hidden');
                stderrPre.textContent = '';
            }
            
            // Assert status
            feedbackClause.classList.remove('hidden');
            if (result.status === 'passed') {
                statusBadge.className = 'badge badge-passed';
                statusBadge.textContent = 'PASSED';
                feedbackText.className = 'text-passed';
                feedbackText.innerHTML = '&#10004; Success! Code output matches the expected result.';
            } else {
                statusBadge.className = 'badge badge-failed';
                statusBadge.textContent = 'FAILED';
                feedbackText.className = 'text-failed';
                feedbackText.innerHTML = '&#10008; Verification failed. Checking output mismatch...';
            }
            
        } catch (err) {
            statusBadge.className = 'badge badge-failed';
            statusBadge.textContent = 'ERROR';
            feedbackClause.classList.remove('hidden');
            feedbackText.className = 'text-failed';
            feedbackText.textContent = 'Failed to execute command on server.';
            errorWrapper.classList.remove('hidden');
            stderrPre.textContent = err.message;
        } finally {
            runBtn.disabled = false;
            runBtn.textContent = 'Run & Test (Ctrl+Enter)';
        }
    });
});
</script>
HTML;

    echo renderLayout($challenge['title'], $body);
}

function renderRunResult(string $slug): void
{
    $challenge = getChallengeBySlug($slug);

    if ($challenge === null) {
        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            header('HTTP/1.1 404 Not Found');
            echo json_encode(['error' => 'Challenge not found']);
            return;
        }
        header('HTTP/1.1 404 Not Found');
        echo renderLayout('Challenge not found', '<p>The requested challenge could not be found.</p>');
        return;
    }

    $sourceCode = trim($_POST['code'] ?? '');
    $contextCode = trim($challenge['context_code'] ?? '');
    $combinedCode = $contextCode . PHP_EOL . $sourceCode;

    $error = null;
    $output = '';

    ob_start();
    try {
        // Run code in eval
        eval($combinedCode);
    } catch (Throwable $exception) {
        $error = $exception->getMessage() . ' on line ' . $exception->getLine();
    }
    $output = ob_get_clean();

    $passed = ($error === null && trim($output) === trim($challenge['expected_output']));

    // Detect AJAX request
    $isAjax = (
        isset($_POST['ajax']) ||
        (strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest') ||
        (str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json'))
    );

    if ($isAjax) {
        header('Content-Type: application/json');
        echo json_encode([
            'output' => $output,
            'expected' => $challenge['expected_output'],
            'status' => $passed ? 'passed' : 'failed',
            'error' => $error
        ]);
        return;
    }

    // Fallback UI
    $escapedOutput = htmlspecialchars($output, ENT_QUOTES, 'UTF-8');
    $statusClass = $passed ? 'text-passed' : 'text-failed';
    $statusLabel = $passed ? 'PASSED' : 'FAILED';

    $body = <<<HTML
<p class="back-link"><a href="/exercises/{$challenge['id']}">&larr; Back to the challenge</a></p>
<h1>Run Result</h1>
<p><strong>Challenge:</strong> {$challenge['title']}</p>
<p><strong>Status:</strong> <span class="{$statusClass}"><strong>{$statusLabel}</strong></span></p>

<h2>Console Output</h2>
<pre><code>{$escapedOutput}</code></pre>
HTML;

    if ($error) {
        $escapedError = htmlspecialchars($error, ENT_QUOTES, 'UTF-8');
        $body .= <<<HTML
<h2>Errors</h2>
<pre class="error-pre"><code>{$escapedError}</code></pre>
HTML;
    }

    echo renderLayout('Run result', $body);
}

// Router Logic
if ($uri === '/' || $uri === '/index.php') {
    renderHomePage();
    return;
}

if ($method === 'POST' && preg_match('#^/challenges/([a-z0-9-]+)/run/?$#', $uri, $matches) === 1) {
    renderRunResult($matches[1]);
    return;
}

if (preg_match('#^/exercises/(\d{3})(?:/task\.php|/templates/task\.php)?/?$#', $uri, $matches) === 1) {
    renderExercisePage($matches[1]);
    return;
}

header('HTTP/1.1 404 Not Found');
echo renderLayout('Not found', '<p>That page does not exist.</p>');
