# WebApp README.md
-------------------------------------------------------------------------------

# About
- This is an WebApp example for M07 DWES.

# Dir structure
- db:     All structured data files: databases, .csv files, etc. 
- public: All static content: img, css, js, etc.
- src:    The main codebase that generates the dynamic content.
- lib: Libraries and third-party code.

# Source
- Start reading src/rewriter.php

# Deployment
- Copy the whole directory containing this file wherever you want.

# Execution with PHP's Development Web Server
- php -S 0.0.0.0:8080 -t public/ src/rewriter.php

# Execution with a production server (Apache, Ngnix, Caddy)
- Configure URL Rewriting.
- Point the web server to execute router.php on every execution.



# Debugging
-------------------------------------------------------------------------------

## VSCode
1. Open debug panel to the left.
2. Generate and open .vscode/launch.json
3. Append the following code to the "configurations" array:

        {
            "name": "Launch Rewriter",
            "type": "php",
            "request": "launch",
            "runtimeArgs": [
                "-dxdebug.mode=debug",
                "-dxdebug.start_with_request=yes",
                "-S",
                "localhost:8080",
                "-t",
                "${fileDirname}/../public",
                "${file}"
            ],
            "program": "",
            "cwd": "${workspaceRoot}",
            "port": 9003,
            "serverReadyAction": {
                "pattern": "Development Server \\(http://localhost:([0-9]+)\\) started",
                "uriFormat": "http://localhost:%s",
                "action": "openExternally"
            }
        }

4. Save .vscode/launch.json
5. Open again the VSCode debug panel in the left.
   At the top of the panel there is a list of four options.
   - Launch currently open script: Runs a script in a terminal.
   - Launch Rewriter: Launches a webapp in PHP's development server.
   Choose "Launch Rewriter", but don't press the "Play" button.
6. Open the file src/rewriter.php and press F5.
7. The debugger will start.
   You can add breakpoints and leave the debugger running while you change code.
   Refresh the browser to see changes.



## Browser
1. Press F12 to open the Developer Tools.
2. Click on the 'Network' Tab.
3. Check 'Disable Cache'. (Very important!)

-------------------------------------------------------------------------------
