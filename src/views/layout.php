<?php

declare(strict_types=1);

function renderLayout(string $title, string $body): string
{
    $escapedTitle = htmlspecialchars($title, ENT_QUOTES, 'UTF-8');

    return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{$escapedTitle}</title>
    <!-- Importing Outfit and Fira Code from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
            
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary: #64748b;
            --secondary-hover: #475569;
            
            --success-bg: #f0fdf4;
            --success-border: #bbf7d0;
            --success-text: #166534;
            
            --error-bg: #fef2f2;
            --error-border: #fecaca;
            --error-text: #991b1b;
            
            --console-bg: #0f172a;
            --console-text: #e2e8f0;
            
            font-family: 'Outfit', system-ui, -apple-system, sans-serif;
            line-height: 1.5;
            color-scheme: light;
        }

        body {
            margin: 0;
            background: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
        }

        a {
            color: var(--primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }
        a:hover {
            color: var(--primary-hover);
        }

        .page-shell {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1.5rem 1rem 3rem;
        }

        .site-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--border-color);
        }
        .site-header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .site-header p {
            margin: 0.25rem 0 0;
            color: var(--text-muted);
            font-size: 0.875rem;
        }
        .home-link {
            font-weight: 500;
            background: #eff6ff;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
        }

        .main-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05), 0 2px 4px -2px rgb(0 0 0 / 0.05);
        }

        /* Welcome & Quotes styling */
        .welcome-section {
            margin-bottom: 2rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }
        .welcome-section h2 {
            margin-top: 0;
        }
        .quote {
            margin-top: 1.25rem;
            padding: 1rem 1.25rem;
            background: #eff6ff;
            border-left: 4px solid var(--primary);
            border-radius: 0 0.5rem 0.5rem 0;
        }
        .quote p {
            margin: 0;
            font-style: italic;
            font-size: 0.95rem;
            color: #1e40af;
        }
        .quote footer {
            margin-top: 0.25rem;
            font-size: 0.8rem;
            font-weight: 500;
            color: #3b82f6;
        }

        /* Exercise List Grid */
        .exercise-list {
            list-style: none;
            padding: 0;
            margin: 1rem 0 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.25rem;
        }
        .exercise-list li {
            padding: 1.25rem;
            border: 1px solid var(--border-color);
            border-radius: 0.625rem;
            background: #fafafb;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .exercise-list li:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.05);
            background: #ffffff;
            border-color: #cbd5e1;
        }
        .exercise-list h3 {
            margin: 0 0 0.5rem;
            font-size: 1.15rem;
            font-weight: 600;
        }
        .exercise-list p.summary {
            margin: 0 0 1rem;
            font-size: 0.9rem;
            color: var(--text-muted);
            flex-grow: 1;
        }
        .meta-tag {
            font-size: 0.8rem;
            background: #f1f5f9;
            color: #475569;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            align-self: flex-start;
            display: inline-block;
        }

        /* Split Pane Layout */
        .back-link {
            font-size: 0.875rem;
            margin-bottom: 1.25rem;
            display: inline-block;
        }

        .split-pane {
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 2rem;
            align-items: start;
        }

        @media (max-width: 900px) {
            .split-pane {
                grid-template-columns: 1fr;
            }
        }

        /* Instruct pane styling */
        .doc-pane h1 {
            margin: 0 0 0.5rem;
            font-size: 1.75rem;
            font-weight: 700;
            letter-spacing: -0.025em;
        }
        .instructions {
            margin: 1.5rem 0;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 1rem;
        }
        .instructions h3, .expected-block h3 {
            margin-top: 0;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
        }
        .instructions p {
            margin: 0;
            font-size: 0.95rem;
        }
        .expected-block pre {
            margin: 0.5rem 0 0;
            background: #f1f5f9;
            border: 1px solid var(--border-color);
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            overflow-x: auto;
        }
        .expected-block code {
            font-family: 'Fira Code', ui-monospace, monospace;
            font-size: 0.875rem;
        }

        /* Editor details */
        .runner-pane form {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }
        .editor-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .editor-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
        }
        .editor-label {
            font-size: 0.75rem;
            font-weight: 500;
            background: #e2e8f0;
            color: #475569;
            padding: 0.2rem 0.5rem;
            border-radius: 0.375rem;
        }
        #code-textarea {
            width: 100%;
            box-sizing: border-box;
            background: var(--console-bg);
            color: var(--console-text);
            font-family: 'Fira Code', ui-monospace, monospace;
            font-size: 0.925rem;
            padding: 1rem;
            border: 1px solid #1e293b;
            border-radius: 0.5rem;
            resize: vertical;
            line-height: 1.45;
            outline: none;
        }
        #code-textarea:focus {
            box-shadow: 0 0 0 2px rgb(37 99 235 / 0.3);
            border-color: var(--primary);
        }

        .action-bar {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }
        .primary-btn, .secondary-btn {
            font-family: inherit;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1.25rem;
            border-radius: 0.375rem;
            cursor: pointer;
            transition: all 0.15s ease;
            border: 1px solid transparent;
        }
        .primary-btn {
            background: var(--primary);
            color: white;
        }
        .primary-btn:hover {
            background: var(--primary-hover);
        }
        .primary-btn:disabled {
            background: #93c5fd;
            cursor: not-allowed;
        }
        .secondary-btn {
            background: white;
            border-color: var(--border-color);
            color: var(--text-main);
        }
        .secondary-btn:hover {
            background: #f1f5f9;
        }

        /* Console Results Output styling */
        .console-box {
            margin-top: 1.5rem;
            background: var(--console-bg);
            color: var(--console-text);
            border-radius: 0.5rem;
            overflow: hidden;
            border: 1px solid #1e293b;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
        }
        .console-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 1rem;
            background: #1e293b;
            border-bottom: 1px solid #334155;
        }
        .console-header h3 {
            margin: 0;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            color: #94a3b8;
            font-weight: 600;
        }
        .console-body {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Badges */
        .badge {
            font-size: 0.75rem;
            font-weight: 600;
            padding: 0.2rem 0.6rem;
            border-radius: 9999px;
            text-transform: uppercase;
        }
        .badge-idle {
            background: #475569;
            color: #f1f5f9;
        }
        .badge-running {
            background: #d97706;
            color: #fef3c7;
        }
        .badge-passed {
            background: #16a34a;
            color: #dcfce7;
        }
        .badge-failed {
            background: #dc2626;
            color: #fee2e2;
        }

        /* Feedback text */
        .feedback-clause {
            padding: 0.625rem;
            border-radius: 0.375rem;
            background: #1e293b;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .hidden {
            display: none !important;
        }
        .feedback-title {
            color: #94a3b8;
            font-weight: 500;
        }
        .text-passed {
            color: #4ade80;
            font-weight: 600;
        }
        .text-failed {
            color: #f87171;
            font-weight: 600;
        }

        .output-wrapper {
            display: flex;
            flex-direction: column;
            gap: 0.35rem;
        }
        .output-wrapper span {
            font-size: 0.75rem;
            font-weight: 500;
            text-transform: uppercase;
            color: #64748b;
        }
        .output-wrapper pre {
            margin: 0;
            padding: 0.75rem;
            background: #020617;
            border: 1px solid #1e293b;
            border-radius: 0.375rem;
            overflow-x: auto;
        }
        .output-wrapper code {
            font-family: 'Fira Code', ui-monospace, monospace;
            font-size: 0.85rem;
            color: #cbd5e1;
        }
        .error-wrapper pre {
            background: #450a0a;
            border-color: #7f1d1d;
        }
        .error-wrapper code {
            color: #fca5a5;
        }
    </style>
</head>
<body>
    <div class="page-shell">
        <header class="site-header">
            <div>
                <h1><a href="/" style="color: inherit;">PHP Practice Field &Sigma;</a></h1>
                <p>Build and maintain PHP coding speed, array methods, and general logic chops.</p>
            </div>
            <a href="/" class="home-link">Home</a>
        </header>

        <main class="main-card">
            {$body}
        </main>
    </div>
</body>
</html>
HTML;
}
