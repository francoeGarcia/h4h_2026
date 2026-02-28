from flask import Flask, render_template, send_from_directory, send_file
import os

app = Flask(__name__, static_folder='public', static_url_path='')

# Serve index.html for the root path
@app.route('/')
def index():
    return send_file('public/index.html')

# Catch-all route to serve index.html for SPA routing
@app.route('/<path:path>')
def serve_spa(path):
    # Serve static files if they exist
    if os.path.isfile(os.path.join('public', path)):
        return send_from_directory('public', path)
    # Otherwise serve index.html for client-side routing
    return send_file('public/index.html')

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)