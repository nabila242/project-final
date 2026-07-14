@extends('layouts.app')

@section('content')
<div class="tab-content">
    
    <!-- 1. Global Dashboard -->
    <div class="tab-pane fade show active" id="dashboard">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Global Country Dashboard</h2>
            <select id="countrySelect" class="form-select bg-dark text-white border-secondary" style="width: 250px;">
                <option value="">Loading countries...</option>
            </select>
        </div>

        <div class="row g-4" id="countryDataContainer" style="display: none;">
            <div class="col-md-3">
                <div class="glass-card p-4 text-center">
                    <div class="metric-label">GDP (USD)</div>
                    <div class="metric-value text-primary" id="valGdp">-</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-4 text-center">
                    <div class="metric-label">Inflation</div>
                    <div class="metric-value text-warning" id="valInflation">-</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-4 text-center">
                    <div class="metric-label">Population</div>
                    <div class="metric-value text-info" id="valPop">-</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-4 text-center">
                    <div class="metric-label">Risk Score</div>
                    <div class="metric-value" id="valRisk">-</div>
                </div>
            </div>
        </div>
        
        <div class="row mt-4" id="countryEmptyState">
            <div class="col-12 text-center text-muted py-5 glass-card">
                <i class="fa-solid fa-globe fa-3x mb-3 opacity-50"></i>
                <h4>Select a country to view intelligence data</h4>
            </div>
        </div>
    </div>

    <!-- 2. Weather Risk -->
    <div class="tab-pane fade" id="weather">
        <h2 class="mb-4">Global Weather Monitoring</h2>
        <div class="glass-card p-3">
            <div id="weatherMap"></div>
        </div>
    </div>

    <!-- 3. Currency Impact -->
    <div class="tab-pane fade" id="currency">
        <h2 class="mb-4">Currency Impact Dashboard</h2>
        <div class="glass-card p-4">
            <canvas id="currencyChart" height="100"></canvas>
        </div>
    </div>

    <!-- 4. News Intelligence -->
    <div class="tab-pane fade" id="news">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>News Intelligence</h2>
            <div class="btn-group">
                <button class="btn btn-outline-success" onclick="filterNews('positive')">Positive</button>
                <button class="btn btn-outline-warning" onclick="filterNews('neutral')">Neutral</button>
                <button class="btn btn-outline-danger" onclick="filterNews('negative')">Negative</button>
                <button class="btn btn-outline-light" onclick="filterNews('')">All</button>
            </div>
        </div>
        <div class="row g-4" id="newsContainer">
            <!-- News items injected via JS -->
        </div>
    </div>

    <!-- 5. Port Locations -->
    <div class="tab-pane fade" id="ports">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>World Port Index</h2>
            <input type="text" id="portSearch" class="form-control bg-dark text-white border-secondary w-25" placeholder="Search port...">
        </div>
        <div class="glass-card p-3">
            <div id="portMap"></div>
        </div>
    </div>

    <!-- 6. Compare Countries -->
    <div class="tab-pane fade" id="compare">
        <h2 class="mb-4">Country Comparison Engine</h2>
        <div class="row g-4">
            <div class="col-md-6">
                <select id="compareA" class="form-select bg-dark text-white border-secondary mb-3"></select>
                <div class="glass-card p-4" id="compareDataA">Select Country A</div>
            </div>
            <div class="col-md-6">
                <select id="compareB" class="form-select bg-dark text-white border-secondary mb-3"></select>
                <div class="glass-card p-4" id="compareDataB">Select Country B</div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Global State
    let countries = [];
    
    // Initialize Dashboard
    document.addEventListener('DOMContentLoaded', async () => {
        await loadCountries();
        initWeatherMap();
        initPortMap();
        loadCurrencyChart();
        loadNews();
    });

    // 1. Load Countries
    async function loadCountries() {
        try {
            const res = await fetch('/api/countries');
            const json = await res.json();
            countries = json.data;
            
            const select = document.getElementById('countrySelect');
            const compA = document.getElementById('compareA');
            const compB = document.getElementById('compareB');
            
            let options = '<option value="">-- Select Country --</option>';
            countries.forEach(c => {
                options += `<option value="${c.id}">${c.name}</option>`;
            });
            
            select.innerHTML = options;
            compA.innerHTML = options;
            compB.innerHTML = options;

            select.addEventListener('change', (e) => showCountryData(e.target.value));
        } catch (e) {
            console.error('Failed to load countries', e);
        }
    }

    function showCountryData(id) {
        if (!id) {
            document.getElementById('countryDataContainer').style.display = 'none';
            document.getElementById('countryEmptyState').style.display = 'block';
            return;
        }

        const c = countries.find(x => x.id == id);
        if(!c) return;

        document.getElementById('countryDataContainer').style.display = 'flex';
        document.getElementById('countryEmptyState').style.display = 'none';

        // Format values
        const gdp = c.latest_economic_indicator ? `$${(c.latest_economic_indicator.gdp / 1e9).toFixed(2)}B` : 'N/A';
        const inf = c.latest_economic_indicator ? `${c.latest_economic_indicator.inflation_rate}%` : 'N/A';
        const pop = c.population ? (c.population / 1e6).toFixed(1) + 'M' : 'N/A';
        
        let riskHtml = 'N/A';
        if (c.latest_risk_score) {
            const level = c.latest_risk_score.risk_level;
            const color = level === 'high' ? 'text-danger' : (level === 'medium' ? 'text-warning' : 'text-success');
            riskHtml = `<span class="${color}">${c.latest_risk_score.total_score} (${level})</span>`;
        }

        document.getElementById('valGdp').innerText = gdp;
        document.getElementById('valInflation').innerText = inf;
        document.getElementById('valPop').innerText = pop;
        document.getElementById('valRisk').innerHTML = riskHtml;
    }

    // 2 & 5. Initialize Maps (Leaflet)
    function initWeatherMap() {
        const map = L.map('weatherMap').setView([20, 0], 2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Fetch weather data and add markers
        fetch('/api/weather').then(r => r.json()).then(data => {
            data.data.forEach(w => {
                const color = w.storm_risk > 50 ? 'red' : 'green';
                L.circleMarker([w.latitude, w.longitude], {
                    radius: 8, fillColor: color, color: '#fff', weight: 1, opacity: 1, fillOpacity: 0.8
                }).addTo(map).bindPopup(`<b>${w.country.name}</b><br>Temp: ${w.temperature}°C<br>Storm Risk: ${w.storm_risk}%`);
            });
        });
        
        // Fix map rendering issue in Bootstrap tabs
        document.querySelector('a[href="#weather"]').addEventListener('shown.bs.tab', () => map.invalidateSize());
    }

    function initPortMap() {
        const map = L.map('portMap').setView([20, 0], 2);
        L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png').addTo(map);

        fetch('/api/ports').then(r => r.json()).then(data => {
            data.data.forEach(p => {
                L.marker([p.latitude, p.longitude]).addTo(map)
                 .bindPopup(`<b>${p.name}</b><br>${p.country ? p.country.name : ''}<br>Size: ${p.harbor_size}`);
            });
        });

        document.querySelector('a[href="#ports"]').addEventListener('shown.bs.tab', () => map.invalidateSize());
    }

    // 3. Currency Chart
    function loadCurrencyChart() {
        const ctx = document.getElementById('currencyChart').getContext('2d');
        // Dummy data for visual effect since we need historical data for a real line chart
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'EUR to USD',
                    data: [1.08, 1.09, 1.07, 1.10, 1.11, 1.09, 1.12],
                    borderColor: '#f59e0b',
                    backgroundColor: 'rgba(245, 158, 11, 0.2)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { labels: { color: '#fff' } } },
                scales: {
                    x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.1)' } },
                    y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.1)' } }
                }
            }
        });
    }

    // 4. News Intelligence
    function loadNews(sentiment = '') {
        const url = sentiment ? `/api/news?sentiment=${sentiment}` : '/api/news';
        fetch(url).then(r => r.json()).then(res => {
            let html = '';
            res.data.data.forEach(n => {
                const badge = n.sentiment === 'positive' ? 'success' : (n.sentiment === 'negative' ? 'danger' : 'warning');
                html += `
                <div class="col-md-6">
                    <div class="glass-card p-3 h-100 d-flex flex-column">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="badge bg-${badge}">${n.sentiment.toUpperCase()} (${n.sentiment_score})</span>
                            <small class="text-muted">${n.country ? n.country.name : 'Global'}</small>
                        </div>
                        <h5>${n.title}</h5>
                        <p class="text-muted small flex-grow-1">${n.description ? n.description.substring(0, 100) + '...' : ''}</p>
                        <a href="${n.url}" target="_blank" class="btn btn-sm btn-outline-primary mt-auto">Read Source</a>
                    </div>
                </div>`;
            });
            document.getElementById('newsContainer').innerHTML = html || '<div class="col-12 text-center">No news found</div>';
        });
    }

    window.filterNews = function(sentiment) {
        loadNews(sentiment);
    }
</script>
@endpush
