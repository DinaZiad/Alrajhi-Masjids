@extends('layouts.admin')

@section('content')
<div class="terminal-container">
    <div class="terminal-header">
        <h2><i class="fas fa-terminal"></i> Server Terminal</h2>
        <p>Execute Laravel commands safely on the server</p>
    </div>

    <div class="terminal-content">
        <!-- Quick Commands -->
        <div class="quick-commands">
            <h3>Quick Commands:</h3>
            <div class="command-buttons">
                <button class="quick-cmd-btn" data-command="php artisan migrate --force">
                    <i class="fas fa-database"></i> Run Migrations
                </button>
                <button class="quick-cmd-btn" data-command="php artisan db:seed --force">
                    <i class="fas fa-seedling"></i> Run All Seeders
                </button>
                <button class="quick-cmd-btn" data-command="php artisan db:seed --class=PermissionSeeder">
                    <i class="fas fa-key"></i> Seed Permissions
                </button>
                <button class="quick-cmd-btn" data-command="php artisan db:seed --class=AdminSeeder">
                    <i class="fas fa-user-shield"></i> Seed Admin
                </button>
                <button class="quick-cmd-btn" data-command="php artisan cache:clear">
                    <i class="fas fa-broom"></i> Clear Cache
                </button>
                <button class="quick-cmd-btn" data-command="php artisan optimize:clear">
                    <i class="fas fa-sync"></i> Clear All Caches
                </button>
                <button class="quick-cmd-btn" data-command="composer install --no-dev --optimize-autoloader">
                    <i class="fas fa-download"></i> Install Dependencies
                </button>
            </div>
        </div>

        <!-- Command Input -->
        <div class="command-input-section">
            <form id="terminal-form">
                @csrf
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" id="command-input" class="form-control" placeholder="Enter command..." autocomplete="off">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-play"></i> Execute
                    </button>
                </div>
            </form>
        </div>

        <!-- Output Area -->
        <div class="terminal-output" id="terminal-output">
            <div class="output-header">Terminal Output:</div>
            <div class="output-content" id="output-content">
                <div class="welcome-message">
                    Welcome to Laravel Terminal Interface<br>
                    Only whitelisted commands are allowed for security.<br>
                    Type a command above or use the quick command buttons.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.terminal-container {
    max-width: 1200px;
    margin: 2rem auto;
    font-family: 'Cairo', sans-serif;
}

.terminal-header {
    background: linear-gradient(135deg, #174032 0%, #14532d 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 12px 12px 0 0;
    text-align: center;
}

.terminal-header h2 {
    margin: 0 0 0.5rem 0;
    font-size: 1.8rem;
    font-weight: 700;
}

.terminal-header p {
    margin: 0;
    opacity: 0.9;
}

.terminal-content {
    background: #f8f9fa;
    border: 2px solid #174032;
    border-top: none;
    border-radius: 0 0 12px 12px;
    padding: 1.5rem;
}

.quick-commands {
    margin-bottom: 2rem;
}

.quick-commands h3 {
    color: #174032;
    margin-bottom: 1rem;
    font-weight: 700;
}

.command-buttons {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 0.75rem;
}

.quick-cmd-btn {
    background: linear-gradient(135deg, #d4af37 0%, #b8941f 100%);
    color: white;
    border: none;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.quick-cmd-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
}

.command-input-section {
    margin-bottom: 1.5rem;
}

.input-group {
    display: flex;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

.input-group-text {
    background: #174032;
    color: #d4af37;
    border: none;
    padding: 0.75rem 1rem;
    font-weight: bold;
    font-family: 'Courier New', monospace;
}

#command-input {
    border: none;
    padding: 0.75rem 1rem;
    font-family: 'Courier New', monospace;
    font-size: 1rem;
    flex: 1;
}

#command-input:focus {
    outline: none;
    box-shadow: none;
}

.btn-primary {
    background: #174032;
    border: none;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #14532d;
    transform: translateY(-1px);
}

.terminal-output {
    background: #1a1a1a;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

.output-header {
    background: #333;
    color: #d4af37;
    padding: 0.75rem 1rem;
    font-weight: 600;
    border-bottom: 1px solid #444;
}

.output-content {
    padding: 1rem;
    min-height: 300px;
    max-height: 500px;
    overflow-y: auto;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    line-height: 1.4;
    color: #00ff00;
    background: #000;
}

.welcome-message {
    color: #888;
    font-style: italic;
}

.command-line {
    margin-bottom: 0.5rem;
}

.command-prompt {
    color: #d4af37;
    font-weight: bold;
}

.command-text {
    color: #fff;
}

.command-output {
    color: #00ff00;
    margin-left: 1rem;
    white-space: pre-wrap;
    margin-bottom: 1rem;
}

.command-error {
    color: #ff4444;
    margin-left: 1rem;
    white-space: pre-wrap;
    margin-bottom: 1rem;
}

.loading {
    color: #ffaa00;
    animation: blink 1s infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.3; }
}

.success-indicator {
    color: #00ff00;
    font-weight: bold;
}

.error-indicator {
    color: #ff4444;
    font-weight: bold;
}

/* Responsive */
@media (max-width: 768px) {
    .terminal-container {
        margin: 1rem;
    }
    
    .command-buttons {
        grid-template-columns: 1fr;
    }
    
    .input-group {
        flex-direction: column;
    }
    
    .input-group-text,
    #command-input,
    .btn-primary {
        border-radius: 0;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('terminal-form');
    const commandInput = document.getElementById('command-input');
    const outputContent = document.getElementById('output-content');
    const quickCmdButtons = document.querySelectorAll('.quick-cmd-btn');

    // Handle quick command buttons
    quickCmdButtons.forEach(button => {
        button.addEventListener('click', function() {
            const command = this.getAttribute('data-command');
            commandInput.value = command;
            executeCommand(command);
        });
    });

    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const command = commandInput.value.trim();
        if (command) {
            executeCommand(command);
        }
    });

    // Execute command function
    function executeCommand(command) {
        // Add command to output
        addToOutput(`<div class="command-line">
            <span class="command-prompt">$ </span>
            <span class="command-text">${escapeHtml(command)}</span>
        </div>`);

        // Show loading
        const loadingId = 'loading-' + Date.now();
        addToOutput(`<div id="${loadingId}" class="loading">Executing command...</div>`);

        // Disable form
        form.style.pointerEvents = 'none';
        commandInput.disabled = true;

        // Send AJAX request
        fetch('{{ route("admin.terminal.execute") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || '{{ csrf_token() }}'
            },
            body: JSON.stringify({ command: command })
        })
        .then(response => response.json())
        .then(data => {
            // Remove loading indicator
            const loadingElement = document.getElementById(loadingId);
            if (loadingElement) {
                loadingElement.remove();
            }

            // Add result to output
            const resultClass = data.success ? 'command-output' : 'command-error';
            const indicator = data.success ? 
                '<span class="success-indicator">[SUCCESS]</span>' : 
                '<span class="error-indicator">[ERROR]</span>';
            
            addToOutput(`<div class="${resultClass}">
                ${indicator} Return Code: ${data.return_code || 'N/A'}<br>
                ${escapeHtml(data.output || 'No output')}
            </div>`);

            // Clear input
            commandInput.value = '';
        })
        .catch(error => {
            // Remove loading indicator
            const loadingElement = document.getElementById(loadingId);
            if (loadingElement) {
                loadingElement.remove();
            }

            addToOutput(`<div class="command-error">
                <span class="error-indicator">[NETWORK ERROR]</span><br>
                ${escapeHtml(error.message)}
            </div>`);
        })
        .finally(() => {
            // Re-enable form
            form.style.pointerEvents = 'auto';
            commandInput.disabled = false;
            commandInput.focus();
        });
    }

    // Add content to output
    function addToOutput(html) {
        outputContent.innerHTML += html;
        outputContent.scrollTop = outputContent.scrollHeight;
    }

    // Escape HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Focus on input
    commandInput.focus();

    // Command history (simple implementation)
    let commandHistory = [];
    let historyIndex = -1;

    commandInput.addEventListener('keydown', function(e) {
        if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (historyIndex < commandHistory.length - 1) {
                historyIndex++;
                this.value = commandHistory[commandHistory.length - 1 - historyIndex] || '';
            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (historyIndex > 0) {
                historyIndex--;
                this.value = commandHistory[commandHistory.length - 1 - historyIndex] || '';
            } else if (historyIndex === 0) {
                historyIndex = -1;
                this.value = '';
            }
        }
    });

    // Add to history when command is executed
    const originalExecuteCommand = executeCommand;
    executeCommand = function(command) {
        if (command && !commandHistory.includes(command)) {
            commandHistory.push(command);
            if (commandHistory.length > 50) { // Limit history
                commandHistory.shift();
            }
        }
        historyIndex = -1;
        originalExecuteCommand(command);
    };
});
</script>
@endsection
