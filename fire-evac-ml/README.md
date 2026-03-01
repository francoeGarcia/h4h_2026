# CA Fire Detection & Personalized Evacuation

A web application for California wildfire detection/prediction and personalized evacuation route planning.

## Project Structure

```
project-root/
|-- frontend/               # React (CRA) client application
|   |-- public/
|   |-- src/
|   |   |-- components/
|   |   |   |-- LocationDisplay.js    # Reads/stores location via cookies
|   |   |   |-- EvacuationForm.js     # User info form (disability, pets, etc.)
|   |   |   |-- ResultsDisplay.js     # Renders backend prediction results
|   |   |-- App.js
|   |   |-- App.css
|   |   |-- index.js
|   |-- package.json
|
|-- backend/                # Flask API server
|   |-- routes/
|   |   |-- predict.py      # /api/predict endpoint
|   |-- app.py              # Flask entry point
|   |-- requirements.txt
|
|-- machine-learning-stuff/ # ML model files & notebooks
|   |-- model.py            # Model wrapper imported by the backend
|   |-- README_ML.txt       # Instructions for adding your model
```

## Prerequisites

- **Node.js** >= 18 and **npm** (for the frontend)
- **Python** >= 3.9 (for the backend)
- (Optional) A Python virtual environment tool (`venv`, `conda`, etc.)

---

## IMPORTANT -- Windows PowerShell Fix

If you see this error when running `npm install` or `venv\Scripts\activate`:

```
cannot be loaded because running scripts is disabled on this system
```

This is a default Windows PowerShell security policy. You only need to fix this **once**. Pick ONE of these options:

### Option A: Change the execution policy (recommended, one-time fix)

Open PowerShell **as Administrator** (right-click > "Run as administrator") and run:

```powershell
Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser
```

Type `Y` to confirm. Close and reopen your terminal. Everything will work normally now.

### Option B: Use Command Prompt instead of PowerShell

Open **Command Prompt** (`cmd.exe`) instead of PowerShell. The `cmd` terminal does not have this restriction. All the same commands work in cmd.

### Option C: Bypass for the current session only

If you don't want to change the global policy, run this at the start of each PowerShell session:

```powershell
Set-ExecutionPolicy -ExecutionPolicy Bypass -Scope Process
```

This only lasts until you close that terminal window.

---

## Setup & Run

### 1. Backend (Flask)

```bash
cd backend

# Create a virtual environment (recommended)
python -m venv venv

# Activate the virtual environment
# macOS / Linux:
source venv/bin/activate
# Windows PowerShell (after fixing execution policy above):
venv\Scripts\activate
# Windows Command Prompt:
venv\Scripts\activate.bat

# Install dependencies
pip install -r requirements.txt

# Start the Flask dev server (runs on port 5000)
python app.py
```

The backend will be available at `http://localhost:5000`.
You can verify it works by visiting: `http://localhost:5000/api/health`

### 2. Frontend (React)

Open a **second terminal**:

```bash
cd frontend

# Install dependencies
npm install

# Start the React dev server (runs on port 3000)
npm start
```

The React app will open at `http://localhost:3000`.
It proxies `/api/*` requests to the Flask server on port 5000 (configured in `frontend/package.json` via the `"proxy"` field).

### 3. Using Both Together

1. Start the backend first (Terminal 1).
2. Start the frontend second (Terminal 2).
3. Open `http://localhost:3000` in your browser.
4. Allow location access when prompted.
5. Fill out the evacuation form and click "Get Evacuation Plan".
6. The frontend sends the data to Flask, which returns placeholder results.

---

## Plugging In Your ML Model

1. Export your trained model from Jupyter (e.g., `joblib.dump(model, 'model.pkl')`).
2. Place the `.pkl` file inside `machine-learning-stuff/`.
3. Edit `machine-learning-stuff/model.py` -- load your model and implement the `predict()` function.
4. In `backend/routes/predict.py`, uncomment the import line:
   ```python
   from model import predict as ml_predict
   ```
5. Replace the placeholder response block with:
   ```python
   result = ml_predict(latitude, longitude, has_disability, has_pets, has_kids, has_medications, other_concerns)
   return jsonify(result)
   ```
6. Restart the Flask server.

---

## Debugging Tips

- **Flask auto-reloads** on file changes because `debug=True` is set in `app.py`.
- **React hot-reloads** via Create React App's built-in dev server.
- Check the browser console (F12) for frontend errors.
- Check the terminal running Flask for backend tracebacks.
- If the proxy isn't working, make sure Flask is running on port 5000 before starting React.
- The `libretranslate` dependency conflict warnings during `pip install` are from an unrelated package on your system and do NOT affect this project. They can be safely ignored.

---

## Next Steps

- Replace the map placeholder with a real map (Leaflet, Google Maps, Mapbox, etc.).
- Integrate the real ML model for fire risk prediction.
- Add persistent storage (database) for user profiles and past evacuations.
- Add authentication if needed.
